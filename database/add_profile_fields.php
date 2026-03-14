<?php
/**
 * Migration: Add profile fields to users table
 * 
 * This script adds the following columns to the users table:
 * - last_name
 * - phone
 * - date_of_birth
 * - role (if not already added)
 */

require_once __DIR__ . '/../app/config/database.php';

try {
    $database = new Database();
    $db = $database->connect();
    
    echo "Starting migration: Adding profile fields to users table...\n";
    
    // Check and add last_name column
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'last_name'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN last_name VARCHAR(255) DEFAULT NULL AFTER name");
        echo "✓ Added 'last_name' column\n";
    } else {
        echo "- 'last_name' column already exists\n";
    }
    
    // Check and add phone column
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'phone'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email");
        echo "✓ Added 'phone' column\n";
    } else {
        echo "- 'phone' column already exists\n";
    }
    
    // Check and add date_of_birth column
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'date_of_birth'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN date_of_birth DATE DEFAULT NULL AFTER phone");
        echo "✓ Added 'date_of_birth' column\n";
    } else {
        echo "- 'date_of_birth' column already exists\n";
    }
    
    // Check and add role column (if not already added by previous migration)
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN role ENUM('customer', 'admin') DEFAULT 'customer' AFTER date_of_birth");
        echo "✓ Added 'role' column\n";
    } else {
        echo "- 'role' column already exists\n";
    }
    
    echo "\n✓ Migration completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
