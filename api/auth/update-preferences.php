<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

$data = json_decode(file_get_contents('php://input'), true);

try {
    // Store preferences in session (you could also store in database)
    $_SESSION['preferences'] = [
        'email_notifications' => isset($data['email_notifications']),
        'sms_notifications' => isset($data['sms_notifications']),
        'newsletter_subscription' => isset($data['newsletter_subscription'])
    ];
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Preferences saved successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to save preferences'
    ]);
}
?>
