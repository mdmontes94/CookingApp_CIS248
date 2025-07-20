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
        SELECT i.ing_name, ri.quantity, ri.unit
        FROM ca_recipe_ingredients ri
        JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
        WHERE ri.recipe_id = ?
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$recipe_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(function($row) 
    {
        return "{$row['quantity']} {$row['unit']} {$row['ing_name']}";
    }, $rows);
}


function searchRecipesWithFilters($ingredient_ids = [], $allergy_filter = null, $category_filter = [], $exclude_category = false, $exclude_ingredient = false) {
    global $pdo;

    $sql = "
        SELECT DISTINCT r.*
        FROM ca_recipes r
        WHERE 1 = 1
    ";

    $params = [];

    // Ingredient filter: require all specified ingredients to be present in the recipe
    if (!empty($ingredient_ids)) 
    {
        foreach ($ingredient_ids as $id) 
        {
            if($exclude_ingredient)
            {
                $sql .= " AND NOT EXISTS (
                    SELECT 1 FROM ca_recipe_ingredients ri
                    WHERE ri.recipe_id = r.recipe_id AND ri.ingredient_id = ?
                )";
                $params[] = $id;
            }
            else
            {
                $sql .= " AND EXISTS (
                    SELECT 1 FROM ca_recipe_ingredients ri
                    WHERE ri.recipe_id = r.recipe_id AND ri.ingredient_id = ?
                )";
                $params[] = $id;
            }
        }
    }

    // Allergy filter: exclude recipes that contain ingredients with this allergy
    if (!empty($allergy_filter)) 
    {
        $sql .= " AND r.recipe_id NOT IN (
            SELECT ri.recipe_id
            FROM ca_recipe_ingredients ri
            JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
            WHERE i.ing_allergy LIKE ?
        )";
        $params[] = "%$allergy_filter%";
    }

    // Category filter: include or exclude based on category ID
    if (!empty($category_filter)) 
    {
        if (!is_array($category_filter)) 
        {
            $category_filter = explode(',', $category_filter); // If passed as comma-separated string
        }
        $placeholders = rtrim(str_repeat('?,', count($category_filter)), ',');

        if ($exclude_category) 
        {
            // Exclude any recipe that uses one of these categories.  This might be a bit broad right now since the categories are "protein" and "vegetable"
            $sql .= " AND r.recipe_id NOT IN (
                SELECT ri.recipe_id
                FROM ca_recipe_ingredients ri
                JOIN ca_ingredients i ON ri.ingredient_id = i.ing_ID
                WHERE i.ing_category IN ($placeholders)
            )";
        } 
        else 
        {
            // Only include recipes that contain at least one ingredient in the category
            //Again pretty broad, but better. "include only recipes that have protein" makes a little bit more sense. 
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

    // Adds readable ingredient names instead of just displaying IDs 
    foreach ($recipes as &$recipe) 
    {
        $recipe['ingredients'] = getIngredientsForRecipe($recipe['recipe_id']);
    }

    return $recipes;
}
