<?php

class RecipeModel {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function createRecipe($name, $ingredients, $instructions, $difficulty, $cook_time) {
        $stmt = $this->db->prepare("INSERT INTO ca_recipes (name, ingredients, instructions, difficulty, cook_time) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $ingredients, $instructions, $difficulty, $cook_time]);
    }

    public function getRecipeById($recipe_id) {
        $stmt = $this->db->prepare("SELECT * FROM ca_recipes WHERE recipe_id = ?");
        $stmt->execute([$recipe_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRecipes() {
        $stmt = $this->db->query("SELECT * FROM ca_recipes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRecipe($recipe_id, $name, $ingredients, $instructions, $difficulty, $cook_time) {
        $stmt = $this->db->prepare("UPDATE ca_recipes SET name = ?, ingredients = ?, instructions = ?, difficulty = ?, cook_time = ? WHERE recipe_id = ?");
        return $stmt->execute([$name, $ingredients, $instructions, $difficulty, $cook_time, $recipe_id]);
    }

    public function deleteRecipe($recipe_id) {
        $stmt = $this->db->prepare("DELETE FROM ca_recipes WHERE recipe_id = ?");
        return $stmt->execute([$recipe_id]);
    }

    // 🍽️ New: Get a random recipe for "Recipe of the Day"
    public function getRandomRecipe() {
        $stmt = $this->db->query("SELECT * FROM ca_recipes ORDER BY RAND() LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getIngredientsForRecipe($recipe_id) {
    $stmt = $this->db->prepare("
        SELECT i.ing_name AS ingredient_name, ri.quantity, ri.unit
        FROM ca_recipe_ingredients ri
        JOIN ca_ingredients i ON ri.ingredient_id = i.ing_id
        WHERE ri.recipe_id = ?
    ");
    $stmt->execute([$recipe_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns array of associative rows
    }

}