<?php
/**
 * Database Migration: Add missing columns to users table
 * Run this script once to update the database schema
 */

require_once __DIR__ . '/../app/config/database.php';

$database = new Database();
$db = $database->connect();

try {
    echo "Starting users table migration...\n";
    
    // Check current table structure
    $stmt = $db->prepare("DESCRIBE users");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $existingColumns = array_column($columns, 'Field');
    
    echo "Current columns: " . implode(', ', $existingColumns) . "\n";
    
    // Columns to add
    $columnsToAdd = ['role', 'phone', 'date_of_birth', 'last_name', 'created_at', 'updated_at'];
    
    foreach ($columnsToAdd as $column) {
        if (!in_array($column, $existingColumns)) {
            echo "Adding column: $column\n";
            
            $sql = "";
            switch ($column) {
                case 'role':
                    $sql = "ALTER TABLE users ADD COLUMN role ENUM('customer', 'admin') DEFAULT 'customer' AFTER email";
                    break;
                case 'phone':
                    $sql = "ALTER TABLE users ADD COLUMN phone VARCHAR(20) AFTER email";
                    break;
                case 'date_of_birth':
                    $sql = "ALTER TABLE users ADD COLUMN date_of_birth DATE AFTER email";
                    break;
                case 'last_name':
                    $sql = "ALTER TABLE users ADD COLUMN last_name VARCHAR(100) AFTER name";
                    break;
                case 'created_at':
                    $sql = "ALTER TABLE users ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER email";
                    break;
                case 'updated_at':
                    $sql = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at";
                    break;
            }
            
            $db->exec($sql);
            echo "✓ Added column: $column\n";
        }
    }
    
    if (count($columnsToAdd) === 0) {
        echo "All required columns already exist.\n";
    } else {
        echo "\nUpdating existing users...\n";
        
        // Set default role for existing users
        $db->exec("UPDATE users SET role = 'customer' WHERE role IS NULL");
        
        // Set default values for new columns
        $db->exec("UPDATE users SET phone = NULL WHERE phone IS NULL");
        $db->exec("UPDATE users SET date_of_birth = NULL WHERE date_of_birth IS NULL");
        $db->exec("UPDATE users SET last_name = NULL WHERE last_name IS NULL");
        
        // Create admin user if not exists
        $adminEmail = 'admin@essystore.com';
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $adminEmail);
        $stmt->execute();
        
        if (!$stmt->fetch()) {
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (:name, :email, :password, :role, NOW())");
            $stmt->bindParam(':name', 'Admin User');
            $stmt->bindParam(':email', $adminEmail);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', 'admin');
            $stmt->execute();
            echo "✓ Admin user created: admin@essystore.com / admin123\n";
        } else {
            echo "ℹ Admin user already exists\n";
        }
        
        echo "\n✅ Migration completed successfully!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
?>
