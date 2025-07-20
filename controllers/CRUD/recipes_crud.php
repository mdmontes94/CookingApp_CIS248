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
function getRecipeById($recipe_id) 
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM ca_recipes WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get all recipes
function getAllRecipes() 
{
    global $pdo;

    $stmt = $pdo->query("SELECT * FROM ca_recipes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

