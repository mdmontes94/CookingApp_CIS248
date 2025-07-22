<?php

require_once 'models/FavoriteModel.php';
require_once 'config/database.php';

class FavoriteController {

    private $favoriteModel;

    public function __construct() {
        global $pdo;
        $this->favoriteModel = new FavoriteModel($pdo);
    }

    public function add($recipe_id) {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        if ($recipe_id) {
            $this->favoriteModel->addFavoriteRecipe($user_id, $recipe_id);
        }

        header("Location: index.php?action=view_recipe&id=$recipe_id");
        exit;
    }

    public function remove($recipe_id) {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        if ($recipe_id) {
            $this->favoriteModel->deleteFavoriteByUserAndRecipe($user_id, $recipe_id);
        }

        header("Location: index.php?action=view_recipe&id=$recipe_id");
        exit;
    }
}
