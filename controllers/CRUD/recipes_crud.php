<?php
require_once __DIR__ . '/db.php';
//The term CRUD and Recipe doesn't seem quite ideal, but hey that's what its called. 
// Create a new recipe
function createRecipe($name, $ingredients, $instructions, $difficulty, $cook_time) 
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO ca_recipes (name, ingredients, instructions, difficulty, cook_time) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $ingredients, $instructions, $difficulty, $cook_time]);
}

// Get a recipe by ID
function getRecipeByID($id) 
{
    global $pdo;

    $sql = "SELECT * FROM ca_recipes WHERE recipe_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) 
    {
        $recipe['ingredients'] = getIngredientsForRecipe($recipe['recipe_id']);
    }

    return $recipe;
}

// Get all recipes
function getAllRecipes() 
{
    global $pdo;

    $sql = "SELECT * FROM ca_recipes";
    $stmt = $pdo->query($sql);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($recipes as &$recipe) 
    {
        $recipe['ingredients'] = getIngredientsForRecipe($recipe['recipe_id']);
    }

    return $recipes;
}

// Update a recipe
function updateRecipe($recipe_id, $name, $ingredients, $instructions, $difficulty, $cook_time) 
{
    global $pdo;

    $stmt = $pdo->prepare("UPDATE ca_recipes SET name = ?, ingredients = ?, instructions = ?, difficulty = ?, cook_time = ? WHERE recipe_id = ?");
    return $stmt->execute([$name, $ingredients, $instructions, $difficulty, $cook_time, $recipe_id]);
}

// Delete a recipe
function deleteRecipe($recipe_id) 
{
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM ca_recipes WHERE recipe_id = ?");
    return $stmt->execute([$recipe_id]);
}

// Grabs the recipe names from ca_recipe_ingredients and returns them so the recipe output doesn't just show "1" and "2"
function getIngredientsForRecipe($recipe_id) {
    global $pdo;
    
    $sql = "
        SELECT i.ing_ID AS ingredient_id, i.ing_name, ri.quantity, ri.unit
        FROM ca_recipe_ingredients ri
        JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
        WHERE ri.recipe_id = ?
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$recipe_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(function($row) {
        return [
            'ingredient_id' => $row['ingredient_id'],
            'name' => $row['ing_name'],
            'unit' => $row['unit'],
            'quantity' => $row['quantity']
        ];
    }, $rows);
}


function searchRecipesWithFilters($ingredient_ids = [], $allergy_filter = null, $category_filter = [], $exclude_category = false, $exclude_ingredient = false) {
    global $pdo;

    $sql = "SELECT DISTINCT r.* FROM ca_recipes r WHERE 1 = 1";
    $params = [];

    // Filter recipes that contain any of the selected ingredients
    if (!empty($ingredient_ids)) {
        $placeholders = rtrim(str_repeat('?,', count($ingredient_ids)), ',');
        $sql .= " AND r.recipe_id IN (
            SELECT recipe_id FROM ca_recipe_ingredients
            WHERE ingredient_id IN ($placeholders)
            GROUP BY recipe_id
        )";
        $params = array_merge($params, $ingredient_ids);
    }

    // Allergy exclusion filter
    if (!empty($allergy_filter)) {
        $sql .= " AND r.recipe_id NOT IN (
            SELECT ri.recipe_id
            FROM ca_recipe_ingredients ri
            JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
            WHERE i.ing_allergy LIKE ?
        )";
        $params[] = "%$allergy_filter%";
    }

    // Category inclusion/exclusion
    if (!empty($category_filter)) {
        if (!is_array($category_filter)) {
            $category_filter = explode(',', $category_filter);
        }
        $placeholders = rtrim(str_repeat('?,', count($category_filter)), ',');

        if ($exclude_category) {
            $sql .= " AND r.recipe_id NOT IN (
                SELECT ri.recipe_id
                FROM ca_recipe_ingredients ri
                JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
                WHERE i.ing_category IN ($placeholders)
            )";
        } else {
            $sql .= " AND r.recipe_id IN (
                SELECT ri.recipe_id
                FROM ca_recipe_ingredients ri
                JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
                WHERE i.ing_category IN ($placeholders)
            )";
        }
        $params = array_merge($params, $category_filter);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enrich with ingredients and calculate match %
    foreach ($recipes as &$recipe) {
        $recipe['ingredients'] = getIngredientsForRecipe($recipe['recipe_id']);

        if (!empty($ingredient_ids)) {
            $stmt = $pdo->prepare("SELECT ingredient_id FROM ca_recipe_ingredients WHERE recipe_id = ?");
            $stmt->execute([$recipe['recipe_id']]);
            $recipeIngIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $matches = array_intersect($ingredient_ids, $recipeIngIds);
            $matchPercent = count($recipeIngIds) > 0
                ? round((count($matches) / count($recipeIngIds)) * 100)
                : 0;

            $recipe['match_percent'] = $matchPercent;
        }
    }

    // Sort by best match
    if (!empty($ingredient_ids)) {
        usort($recipes, function ($a, $b) {
            return ($b['match_percent'] ?? 0) <=> ($a['match_percent'] ?? 0);
        });
    }

    return $recipes;
}

