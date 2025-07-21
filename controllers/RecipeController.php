<?php

require_once 'models/RecipeModel.php';
require_once 'config/database.php';

class RecipeController {

    private $recipeModel;

    public function __construct() {
        global $pdo;
        $this->recipeModel = new RecipeModel($pdo);
    }

    // Display all recipes
    public function index() {
        $recipes = $this->recipeModel->getAllRecipes();
        include 'views/recipe/list.php'; // make this view
    }

    // Show one recipe
    public function view($id) {
        $recipe = $this->recipeModel->getRecipeById($id);
        $ingredients = $this->recipeModel->getIngredientsForRecipe($recipe['recipe_id']);
        include 'views/recipe/selected_recipe.php';
    }

    // Show recipe of the day
    public function daily() {
        $recipe = $this->recipeModel->getRandomRecipe();
         
        if ($recipe) {
        $ingredients = $this->recipeModel->getIngredientsForRecipe($recipe['recipe_id']);
        } 
        else {
            $ingredients = []; // Avoid undefined warning if no recipe is found
        }
        
        include 'views/recipe/daily.php';
    }

    // Add/edit/delete methods can go here as needed later
}

?>
