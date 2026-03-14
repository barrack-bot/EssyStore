<?php

header('Content-Type: application/json');

session_start();

try {
    // Clear the cart
    $_SESSION['cart'] = [];
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Cart cleared successfully',
        'item_count' => 0
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to clear cart'
    ]);
}
?>
