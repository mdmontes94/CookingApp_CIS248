<?php

require_once 'models/IngredientModel.php';
require_once 'config/database.php';

class IngredientController {

    private $ingredientModel;
    private $pdo; // Add this property

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo; // Save to use later
        $this->ingredientModel = new IngredientModel($pdo);
    }

    public function searchForm() {
        $categories = $this->ingredientModel->getAllCategories();
        $ingredients = $this->ingredientModel->getAllIngredients();
        $allergies = $this->ingredientModel->getAllAllergies();

        include 'views/recipe/ingredient_form.php';
    }
}
?>
