<?php
require_once 'models/PantryModel.php';
require_once 'config/database.php';

class PantryController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new PantryModel($pdo);
    }

    public function addToPantry() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $ingredientIdsRaw = $_POST['ingredient'] ?? [];

            // Convert to array if it’s a comma-separated string
            if (is_string($ingredientIdsRaw)) {
                $ingredientIds = explode(',', $ingredientIdsRaw);
            } else {
                $ingredientIds = (array)$ingredientIdsRaw;
            }

            // Debug output
            echo "<pre>DEBUG User ID: $userId\n";
            echo "DEBUG Ingredient IDs: "; print_r($ingredientIds); echo "</pre>";

            $ingredientIds = array_unique(array_filter($ingredientIds)); // Clean input

            foreach ($ingredientIds as $ingId) {
                $this->model->addPantryIngredient($userId, $ingId);
            }

            echo "Success";
        } else {
            echo "Unauthorized or Invalid Request";
        }
    }

    public function removeFromPantryAjax() {
    echo "<pre>DEBUG: removeFromPantryAjax called\n";

    if (isset($_GET['id'], $_SESSION['user']['id'])) {
        $userId = $_SESSION['user']['id'];
        $ingredientId = intval($_GET['id']);

        echo "User ID: $userId\n";
        echo "Ingredient ID: $ingredientId\n";

        if ($this->model->removePantryIngredient($userId, $ingredientId)) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "unauthorized";
    }
}
         
}