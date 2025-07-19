<?php
require_once 'favorites_crud.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // Add favorite
        $user_id = $_POST['user_id'];
        $recipe_id = $_POST['recipe_id'];
        if (addFavoriteRecipe($user_id, $recipe_id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        break;

    case 'GET':
        // Get favorites for a user
        $user_id = $_GET['user_id'] ?? null;
        if ($user_id) {
            $favorites = getFavoritesByUser($user_id);
            echo json_encode($favorites);
        } else {
            echo json_encode(['error' => 'Missing user_id']);
        }
        break;

    case 'DELETE':
        // Use raw input to parse DELETE request
        parse_str(file_get_contents("php://input"), $data);
        $favorite_id = $data['favorite_id'] ?? null;

        if ($favorite_id && deleteFavoriteById($favorite_id)) {
            echo json_encode(['status' => 'deleted']);
        } else {
            echo json_encode(['error' => 'Delete failed or missing favorite_id']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request']);
}