<?php
/**
 * Create Admin User
 * This script creates the admin user in the database
 */

require_once __DIR__ . '/../app/config/database.php';

try {
    $database = new Database();
    $db = $database->connect();
    
    echo "Creating admin user...\n";
    
    // Check if admin user already exists
    $adminEmail = 'admin@essystore.com';
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $adminEmail);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo "ℹ Admin user already exists: $adminEmail\n";
    } else {
        // Create admin user
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        
        $name = 'Admin User';
        $email = $adminEmail;
        $password = $hashedPassword;
        $role = 'admin';
        
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $role);
        
        if ($stmt->execute()) {
            echo "✓ Admin user created successfully!\n";
            echo "  Email: $adminEmail\n";
            echo "  Password: admin123\n";
            echo "  Role: admin\n";
            echo "  ID: " . $db->lastInsertId() . "\n";
        } else {
            echo "❌ Failed to create admin user\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
