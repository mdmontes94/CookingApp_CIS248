<?php

class FavoriteModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    // Create: Add a new favorite
    function addFavoriteRecipe($user_id, $recipe_id) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO ca_favorites (user_id, recipe_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $recipe_id]);
    }

    // Read: Get all favorite recipes for a user
    function getFavoritesByUser($user_id) {
        $stmt = $pdo->prepare("SELECT * FROM ca_favorites WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete: Remove a favorite by favorite_id
    function deleteFavoriteById($favorite_id) {
        $stmt = $pdo->prepare("DELETE FROM ca_favorites WHERE favorite_id = ?");
        return $stmt->execute([$favorite_id]);
    }

    // Optional: Remove a favorite by user + recipe
    function deleteFavoriteByUserAndRecipe($user_id, $recipe_id) {
        $stmt = $pdo->prepare("DELETE FROM ca_favorites WHERE user_id = ? AND recipe_id = ?");
        return $stmt->execute([$user_id, $recipe_id]);
    }

}