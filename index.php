<?php
// Start the session once globally
session_start();

// Include the database and controller
require_once 'config/database.php';
require_once 'controllers/UserController.php';

// Get action from query string or fallback to home
$action = $_GET['action'] ?? 'home';

// Instantiate the controller
$controller = new UserController();

// Route to correct method or view
switch ($action) {
    case 'login':
        $controller->showLogin();
        break;
    case 'loginSubmit':
        $controller->login();
        break;
    case 'signup':
        $controller->showSignup();
        break;
    case 'signupSubmit':
        $controller->signup();
        break;
    case 'account':
        $controller->account();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'home':
    default:
        include 'views/main_page.php'; 
        break;
}


