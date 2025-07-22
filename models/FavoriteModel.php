<?php

class FavoriteModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Create: Add a new favorite
    public function addFavoriteRecipe($user_id, $recipe_id) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO ca_favorites (user_id, recipe_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $recipe_id]);
    }   

    // Read: Get all favorite recipes for a user
    public function getFavoritesByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM ca_favorites WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete: Remove a favorite by favorite_id
    public function deleteFavoriteById($favorite_id) {
        $stmt = $this->db->prepare("DELETE FROM ca_favorites WHERE favorite_id = ?");
        return $stmt->execute([$favorite_id]);
    }

    // Optional: Remove a favorite by user + recipe
    public function deleteFavoriteByUserAndRecipe($user_id, $recipe_id) {
        $stmt = $this->db->prepare("DELETE FROM ca_favorites WHERE user_id = ? AND recipe_id = ?");
        return $stmt->execute([$user_id, $recipe_id]);
    }
}
