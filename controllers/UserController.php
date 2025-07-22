<?php

require_once 'models/UserModel.php';
require_once 'config/database.php';

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
        $_SESSION['user_id'] = $user['user_id'];  // ✅ Set this for other logic
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

        global $pdo;

        $user = $_SESSION['user'];
        $userId = $user['id'];

        require_once 'models/FavoriteModel.php';
        require_once 'models/RecipeModel.php';
        require_once 'models/PantryModel.php';

        $favModel = new FavoriteModel($pdo);
        $recipeModel = new RecipeModel($pdo);
        $pantryModel = new PantryModel($pdo);

        // Get favorite recipes
        $favorites = $favModel->getFavoritesByUser($userId);
        foreach ($favorites as &$fav) {
            $recipe = $recipeModel->getRecipeById($fav['recipe_id']);
            $fav['name'] = $recipe['name'] ?? 'Unknown';
        }

        // Get pantry ingredients
        $pantryItems = $pantryModel->getPantryByUser($userId);

        include 'views/user/account.php';
    }

    // Logout
    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
    }
}
