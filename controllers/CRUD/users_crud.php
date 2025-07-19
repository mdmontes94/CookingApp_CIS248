<?php
require_once __DIR__ . '/db.php';
// Create a new user
function createUser($username, $email, $password_plaintext) {
    global $pdo;

    $password_hash = password_hash($password_plaintext, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO ca_users (username, email, password_hash) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $password_hash]);
}

// Get a user by ID
function getUserById($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT user_id, username, email, created_date FROM ca_users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get all users
function getAllUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT user_id, username, email, created_date FROM ca_users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update user email or username
function updateUser($user_id, $username, $email) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE ca_users SET username = ?, email = ? WHERE user_id = ?");
    return $stmt->execute([$username, $email, $user_id]);
}

// Delete a user
function deleteUser($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM ca_users WHERE user_id = ?");
    return $stmt->execute([$user_id]);
}
