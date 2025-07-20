<?php
require_once 'recipes_crud.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) 
{
    case 'POST':

        $name = $_POST['name'] ?? null;
        $ingredients = $_POST['ingredients'] ?? null;
        $instructions = $_POST['instructions'] ?? null;
        $difficulty = $_POST['difficulty'] ?? null;
        $cook_time = $_POST['cook_time'] ?? null;

        if ($name && $ingredients && $instructions && $difficulty && $cook_time) 
        {
            if (createRecipe($name, $ingredients, $instructions, $difficulty, $cook_time)) 
            {
                echo json_encode(['status' => 'success']);
            } else 
            {
                echo json_encode(['error' => 'Recipe creation failed.']);
            }
        } 
        else 
        {
            echo json_encode(['error' => 'Missing fields.']);
        }
        break;

    case 'GET':
        $recipe_id = $_GET['recipe_id'] ?? null;

        if ($recipe_id) {
            $recipe = getRecipeById($recipe_id);
            echo json_encode($recipe ?: ['error' => 'Recipe not found.']);
        } else {
            $recipes = getAllRecipes();
            echo json_encode($recipes);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $data);
        $recipe_id = $data['recipe_id'] ?? null;
        $name = $data['name'] ?? null;
        $ingredients = $data['ingredients'] ?? null;
        $instructions = $data['instructions'] ?? null;
        $difficulty = $data['difficulty'] ?? null;
        $cook_time = $data['cook_time'] ?? null;

        if ($recipe_id && $name && $ingredients && $instructions && $difficulty && $cook_time) 
        {
            if (updateRecipe($recipe_id, $name, $ingredients, $instructions, $difficulty, $cook_time)) 
            {
                echo json_encode(['status' => 'updated']);
            } 
            else 
            {
                echo json_encode(['error' => 'Update failed.']);
            }
        } 
        else 
        {
            echo json_encode(['error' => 'Missing fields.']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        $recipe_id = $data['recipe_id'] ?? null;

        if ($recipe_id && deleteRecipe($recipe_id)) 
        {
            echo json_encode(['status' => 'deleted']);
        } 
        else 
        {
            echo json_encode(['error' => 'Delete failed or missing recipe_id.']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request method']);
}