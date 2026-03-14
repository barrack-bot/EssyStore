<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

require_once __DIR__ . '/../../app/models/User.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Name, email, and password are required'
    ]);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$password = $data['password'];

if (empty($name) || empty($email) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email format'
    ]);
    exit;
}

$user = new User();
$existingUser = $user->findByEmail($email);

if ($existingUser) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email already exists'
    ]);
    exit;
}

if ($user->create($name, $email, $password)) {
        $newUserId = $user->findByEmail($email);
        $_SESSION['user'] = [
            'id' => $newUserId,
            'name' => $data['name'],
            'email' => $data['email']
        ];
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful',
            'user' => [
                'id' => $newUserId,
                'name' => $data['name'],
                'email' => $data['email']
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Registration failed'
        ]);
    }
