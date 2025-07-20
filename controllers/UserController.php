<?php

require_once 'models/UserModel.php';
require_once 'config/database.php'; // assuming this is where your $pdo is

class UserController {

    private $userModel;

    public function __construct() {
        global $pdo; // ensure $pdo is available from database config
        $this->userModel = new UserModel($pdo);
    }

    public function login() {
        session_start();

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

    // and same for signup(), etc.
}

?>
