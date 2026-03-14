<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EssyStore - Your Online Shop</title>
</head>
<body>
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="py-4">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <a href="shop.php" class="text-2xl font-bold text-blue-600">EssyStore</a>
                
                <ul class="flex space-x-6">
                    <li><a href="shop.php" class="text-gray-700 hover:text-blue-600 font-medium">Home</a></li>
                    <li><a href="shop.php" class="text-gray-700 hover:text-blue-600 font-medium">Shop</a></li>
                </ul>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <a href="cart.php" class="text-gray-700 hover:text-blue-600">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 2L6 9H22L19 2H9Z"/>
                                <path d="M6 9H6.01"/>
                                <path d="M22 9H22.01"/>
                                <path d="M6 9V20C6 21.1 6.9 22 8 22H16C17.1 22 18 21.1 18 20V9"/>
                                <circle cx="9" cy="22" r="1"/>
                                <circle cx="15" cy="22" r="1"/>
                            </svg>
                            <span id="cartCount" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold" style="display: none;">0</span>
                        </a>
                    </div>
                    
                    <div id="authButtons" class="flex space-x-2">
                        <button id="loginBtn" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">Login</button>
                        <button id="registerBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</button>
                    </div>
                    
                    <div id="userMenu" class="flex items-center space-x-2" style="display: none;">
                        <span id="userName"></span>
                        <button id="logoutBtn" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">Logout</button>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="min-h-screen">
