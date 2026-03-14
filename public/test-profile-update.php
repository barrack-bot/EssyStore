<?php
session_start();

// Simulate logged in user
$_SESSION['user'] = [
    'id' => 1,
    'name' => 'Test User',
    'email' => 'test@example.com'
];

header('Content-Type: application/json');
echo json_encode([
    'session_user' => $_SESSION['user']
]);
?>
