<?php

require_once __DIR__ . '/../controllers/CRUD/recipes_crud.php';

class RecipeModel {

    public function createRecipe($name, $ingredients, $instructions, $difficulty, $cook_time) {
        return createRecipe($name, $ingredients, $instructions, $difficulty, $cook_time);
    }

    public function getRecipeById($recipe_id) {
        return getRecipeByID($recipe_id);
    }

    public function getAllRecipes() {
        return getAllRecipes();
    }

    public function updateRecipe($recipe_id, $name, $ingredients, $instructions, $difficulty, $cook_time) {
        return updateRecipe($recipe_id, $name, $ingredients, $instructions, $difficulty, $cook_time);
    }

    public function deleteRecipe($recipe_id) {
        return deleteRecipe($recipe_id);
    }

    public function getRandomRecipe() {
        $recipes = getAllRecipes();
        return $recipes[array_rand($recipes)];
    }

    public function getIngredientsForRecipe($recipe_id) {
        return getIngredientsForRecipe($recipe_id);
    }

    public function searchRecipesWithFilters($ingredient_ids = [], $allergy = null, $categories = [], $excludeCat = false, $excludeIng = false) {
    // 🔒 Ensure $ingredient_ids is an array
    if (is_string($ingredient_ids)) {
        $ingredient_ids = array_map('intval', explode(',', $ingredient_ids));
    } elseif (!is_array($ingredient_ids)) {
        $ingredient_ids = [];
    }

    return searchRecipesWithFilters($ingredient_ids, $allergy, $categories, $excludeCat, $excludeIng);
}

}
?>