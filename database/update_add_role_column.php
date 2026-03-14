<?php
/**
 * Database Migration: Add role column to users table
 * Run this script once to update the database schema
 */

require_once __DIR__ . '/../app/config/database.php';

$database = new Database();
$db = $database->connect();

try {
    // Check if role column already exists
    $stmt = $db->prepare("SHOW COLUMNS FROM users LIKE 'role'");
    $stmt->execute();
    $columnExists = $stmt->fetch();

    if (!$columnExists) {
        // Add role column
        $db->exec("ALTER TABLE users ADD COLUMN role ENUM('customer', 'admin') DEFAULT 'customer' AFTER email");
        
        // Update existing users to 'customer' role (they already default to customer)
        $db->exec("UPDATE users SET role = 'customer' WHERE role IS NULL");
        
        echo "Migration successful: role column added to users table\n";
        
        // Create an admin user (demo purposes)
        $adminEmail = 'admin@essystore.com';
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $adminEmail);
        $stmt->execute();
        
        if (!$stmt->fetch()) {
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            $stmt->bindParam(':name', $name = 'Admin User');
            $stmt->bindParam(':email', $adminEmail);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role = 'admin');
            $stmt->execute();
            echo "Admin user created: admin@essystore.com / admin123\n";
        }
    } else {
        echo "Role column already exists in users table\n";
    }
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
