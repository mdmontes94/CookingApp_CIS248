<?php

class PantryModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Get pantry ingredients by user
    public function getPantryByUser($user_id) {
    $stmt = $this->db->prepare("
        SELECT i.Ing_Name, c.ing_cat_name, i.Ing_ID
        FROM ca_user_pantry p
        JOIN ca_ingredients i ON p.ingredient_id = i.Ing_ID
        JOIN ca_ingcategory c ON i.ing_category = c.ing_cat_id
        WHERE p.user_id = ?
        ORDER BY c.ing_cat_name, i.Ing_Name
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Add an ingredient to the user's pantry
    public function addPantryIngredient($user_id, $ingredient_id) {
    // Only insert if it doesn't already exist
    $stmt = $this->db->prepare("
        SELECT * FROM ca_user_pantry WHERE user_id = ? AND ingredient_id = ?
    ");
    $stmt->execute([$user_id, $ingredient_id]);

    if ($stmt->rowCount() === 0) {
        $insert = $this->db->prepare("
            INSERT INTO ca_user_pantry (user_id, ingredient_id) VALUES (?, ?)
        ");
        return $insert->execute([$user_id, $ingredient_id]);
    }

    return false; // Already exists
    }

    // Remove an ingredient from the pantry
    public function removePantryIngredient($user_id, $ingredient_id) {
        $stmt = $this->db->prepare("
            DELETE FROM ca_user_pantry WHERE user_id = ? AND ingredient_id = ?
        ");
        return $stmt->execute([$user_id, $ingredient_id]);
    }
}

