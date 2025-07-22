<?php
session_start();

// Core configuration
require_once 'config/database.php';
require_once 'models/RecipeModel.php';
require_once 'controllers/UserController.php';
require_once 'controllers/RecipeController.php';
require_once 'controllers/IngredientController.php';
require_once 'controllers/FavoriteController.php';
require_once 'controllers/PantryController.php';

// Instantiate shared controllers
$userController = new UserController();
$recipeController = new RecipeController();

// Determine action
$action = $_GET['action'] ?? 'home';

switch ($action) {

    // --- User Authentication ---
    case 'login':
        $userController->showLogin();
        break;

    case 'loginSubmit':
        $userController->login();
        break;

    case 'signup':
        $userController->showSignup();
        break;

    case 'signupSubmit':
        $userController->signup();
        break;

    case 'logout':
        $userController->logout();
        break;

    case 'account':
        $userController->account();
        break;

    // --- Recipe Actions ---
    case 'recipes':
        $recipeController->index();
        break;

    case 'recipe_day':
        $recipeController->daily();
        break;

    case 'view_recipe':
        if (!empty($_GET['id'])) {
            $recipeController->view($_GET['id']);
        } else {
            header("Location: index.php?action=recipes");
        }
        break;

    // --- Ingredient Actions ---
    case 'find_recipe':
        $ingredientController = new IngredientController();
        $ingredientController->searchForm();
        break;

    case 'match_recipes':
        $recipeController = new RecipeController();
        $recipeController->matchRecipes();
        break;


    // --- Favorites ---
    case 'favorite_add':
    if (!empty($_GET['recipe_id']) && isset($_SESSION['user']['id'])) {
        $favController = new FavoriteController();
        $favController->add($_GET['recipe_id']);
    } else {
        header("Location: index.php?action=login");
    }
    break;

    case 'favorite_remove':
    if (!empty($_GET['recipe_id']) && isset($_SESSION['user']['id'])) {
        $favController = new FavoriteController();
        $favController->remove($_GET['recipe_id']);
    } else {
        header("Location: index.php?action=login");
    }
    break;


    // --- Pantry ---
    case 'add_to_pantry':
        if (isset($_SESSION['user_id'])) {
            $pantryController = new PantryController();
            $pantryController->addToPantry();
        } else {
            echo "Not authorized.";
        }
        break;
    case 'remove_pantry_item_ajax':
        if (isset($_SESSION['user']['id'])) {
            $pantryController = new PantryController();
            $pantryController->removeFromPantryAjax();
        } else {
            echo "Unauthorized.";
        }
        break;


    // --- Home (Default) ---
    case 'home':
    default:
        $recipeModel = new RecipeModel($pdo);
        $recipeOfTheDay = $recipeModel->getRandomRecipe();
        include 'views/main_page.php';
        break;
}
