<?php
require_once 'recipes_crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ingredient_ids = [];
    if (!empty($_GET['ingredients'])) {
        $ingredient_ids = array_map('intval', explode(',', $_GET['ingredients']));
    }

    $allergy_filter = $_GET['allergy_filter'] ?? null;
    $category_filter = $_GET['category_filter'] ?? null;
    $exclude_category = isset($_GET['exclude_category']);
    $exclude_ingredients = isset($_GET['exclude_ingredient']);

    $results = searchRecipesWithFilters($ingredient_ids, $allergy_filter, $category_filter, $exclude_category, $exclude_ingredients);
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);
}
?>
