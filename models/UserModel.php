<?php
class UserModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function 
    // Create a new user
    public function createUser($username, $email, $password_plaintext) {

        $password_hash = password_hash($password_plaintext, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO ca_users (username, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $password_hash]);
    }

    // Get a user by ID
    public function getUserById($user_id) {
        $stmt = $pdo->prepare("SELECT user_id, username, email, created_date FROM ca_users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users
    public function getAllUsers() {
        $stmt = $pdo->query("SELECT user_id, username, email, created_date FROM ca_users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update user email or username
    public function updateUser($user_id, $username, $email) {
        $stmt = $pdo->prepare("UPDATE ca_users SET username = ?, email = ? WHERE user_id = ?");
        return $stmt->execute([$username, $email, $user_id]);
    }

    // Delete a user
    public function deleteUser($user_id) {
        $stmt = $pdo->prepare("DELETE FROM ca_users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

}