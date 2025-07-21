<?php

require_once 'models/UserModel.php';
require_once 'config/database.php'; // pulls in $pdo

class UserController {

    private $userModel;

    public function __construct() {
        global $pdo;
        $this->userModel = new UserModel($pdo);
    }

    // Show the login form
    public function showLogin() {
        include 'views/user/login.php';
    }

    // Handle login submission
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['user_id'],
                'name' => $user['username'],
                'email' => $user['email']
            ];
            header('Location: index.php?action=account');
        } else {
            $error = "Invalid email or password.";
            include 'views/user/login.php';
        }
    }

    // Show the signup form
    public function showSignup() {
        include 'views/user/signup.php';
    }

    // Handle signup submission
    public function signup() {
        $username = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $error = "All fields are required.";
            include 'views/user/signup.php';
            return;
        }

        if ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
            include 'views/user/signup.php';
            return;
        }

        if ($this->userModel->getUserByEmail($email)) {
            $error = "Email is already registered.";
            include 'views/user/signup.php';
            return;
        }

        $this->userModel->createUser($username, $email, $password);
        header('Location: index.php?action=login');
    }

    // Show the account page
    public function account() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            return;
        }

        $user = $_SESSION['user'];
        include 'views/user/account.php';
    }

    // Logout
    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
    }
}
