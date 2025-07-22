<?php

require_once 'models/RecipeModel.php';
require_once 'models/IngredientModel.php';
require_once 'config/database.php';

class RecipeController {

    private $recipeModel;
    private $ingredientModel;

    public function __construct() {
        global $pdo;
        $this->recipeModel = new RecipeModel($pdo);
        $this->ingredientModel = new IngredientModel($pdo);
    }

    public function index() {
        $recipes = $this->recipeModel->getAllRecipes();
        include 'views/recipe/list.php';
    }

    public function daily() {
        global $pdo;

        $recipe = $this->recipeModel->getRandomRecipe();
        $ingredients = $recipe['ingredients'] ?? [];

        // Favorite logic
        $favorited = false;
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            require_once 'models/FavoriteModel.php';
            $favModel = new FavoriteModel($pdo);
            $favorites = $favModel->getFavoritesByUser($userId);
            foreach ($favorites as $fav) {
                if ($fav['recipe_id'] == $recipe['recipe_id']) {
                    $favorited = true;
                    break;
                }
            }
        }

        include 'views/recipe/daily.php';
    }

    public function matchRecipes() {
    global $pdo;

    // Parse ingredient input
    $ingredientParam = $_POST['ingredient'] ?? [];

    $ingredientIds = [];

    if (is_string($ingredientParam)) {
        // Handle: name="ingredient" single string like "13,8,10"
        $ingredientIds = array_map('intval', explode(',', $ingredientParam));
    } elseif (is_array($ingredientParam)) {
        // Handle: name="ingredient[]" with JS set like ["13,8,10"]
        foreach ($ingredientParam as $item) {
            $parts = explode(',', $item); // support comma-separated value in each array item
            foreach ($parts as $id) {
                $ingredientIds[] = intval(trim($id));
            }
        }
    }

    $ingredientIds = array_filter(array_unique($ingredientIds)); // remove 0s, duplicates

    // Filters
    $allergy = $_POST['allergy_filter'] ?? null;
    $categories = $_POST['category'] ?? [];
    $excludeCategory = isset($_POST['exclude_category']);
    $excludeIngredient = isset($_POST['exclude_ingredient']);

    // Fetch matched recipes
    $matchedRecipes = $this->recipeModel->searchRecipesWithFilters(
        $ingredientIds,
        $allergy,
        $categories,
        $excludeCategory,
        $excludeIngredient
    );

    // Ingredient names for highlighting
    $ingredientNamesLower = [];
    foreach ($ingredientIds as $id) {
        $ingredient = $this->ingredientModel->getIngredientById($id);
        if ($ingredient && isset ($ingredient['ing_name '])) {
            $ingredientNamesLower[] = strtolower($ingredient['ing_name']);
        }
    }

    // Store in session
    $_SESSION['last_selected_ingredient_ids'] = $ingredientIds;
    $_SESSION['last_selected_ingredient_names'] = $ingredientNamesLower;
    
    $selectedAllergy = $allergy;
    $allergyName = null;
    if ($allergy && is_numeric($allergy)) {
    require_once 'models/IngredientModel.php';
    $ingredientModel = new IngredientModel($pdo);
    $allergyRow = $ingredientModel->getAllergyById((int)$allergy);
    $allergyName = $allergyRow ? $allergyRow['allergy_name'] : null;
}


    include 'views/recipe/matched_recipes.php';
}


    public function view($id) {
        global $pdo;

        $recipe = $this->recipeModel->getRecipeById($id);
        $ingredients = $recipe['ingredients'] ?? [];

        // Ingredient highlighting
        $selectedIngredientIds = $_SESSION['last_selected_ingredient_ids'] ?? [];
        $ingredientNamesLower = $_SESSION['last_selected_ingredient_names'] ?? [];

        $favorited = false;
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            require_once 'models/FavoriteModel.php';
            $favModel = new FavoriteModel($pdo);
            $favorites = $favModel->getFavoritesByUser($userId);
            foreach ($favorites as $fav) {
                if ($fav['recipe_id'] == $recipe['recipe_id']) {
                    $favorited = true;
                    break;
                }
            }
        }

        include 'views/recipe/selected_recipe.php';
    }

    public function search($ingredient_ids, $allergy = null, $categories = [], $excludeCat = false, $excludeIng = false) {
        $recipes = $this->recipeModel->searchRecipesWithFilters($ingredient_ids, $allergy, $categories, $excludeCat, $excludeIng);

        $ingredientNamesLower = [];
        foreach ($ingredient_ids as $id) {
            $ingredient = $this->ingredientModel->getIngredientById($id);
            if ($ingredient) {
                $ingredientNamesLower[] = strtolower($ingredient['ing_name']);
            }
        }

        $_SESSION['last_selected_ingredient_ids'] = $ingredient_ids;
        $_SESSION['last_selected_ingredient_names'] = $ingredientNamesLower;
        $selectedAllergy = $allergy;

        include 'views/recipe/matched_recipes.php';
    }
}
