<?php
session_start();

require_once 'config/database.php';
require_once 'controllers/UserController.php';
require_once 'controllers/RecipeController.php';
require_once 'models/RecipeModel.php';

// Get the action from query string
$action = $_GET['action'] ?? 'home';

// Instantiate controllers
$userController = new UserController();
$recipeController = new RecipeController();

// Routing logic
switch ($action) {
    // --- User Actions ---
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
    case 'account':
        $userController->account();
        break;
    case 'logout':
        $userController->logout();
        break;

    // --- Recipe Actions ---
    case 'recipe_day': // View recipe of the day
        $recipeController->daily();
        break;
    case 'recipes': // All recipes (optional future)
        $recipeController->index();
        break;
    case 'view_recipe': // View recipe by ID
        if (isset($_GET['id'])) {
            $recipeController->view($_GET['id']);
        } else {
            header("Location: index.php?action=recipes");
        }
        break;

    // --- Home (with recipe of the day) ---
    case 'home':
    default:
        $recipeModel = new RecipeModel($pdo);
        $recipeOfTheDay = $recipeModel->getRandomRecipe();
        include 'views/main_page.php';
        break;
}
