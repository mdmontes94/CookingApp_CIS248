<?php
require_once 'users_crud.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) 
{
    case 'POST':
        // Create user
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($username && $email && $password) {
            if (createUser($username, $email, $password)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['error' => 'User creation failed.']);
            }
        } else {
            echo json_encode(['error' => 'Missing fields.']);
        }
        break;

    case 'GET':
        // Get user or all users
        $user_id = $_GET['user_id'] ?? null;

        if ($user_id) {
            $user = getUserById($user_id);
            echo json_encode($user ?: ['error' => 'User not found.']);
        } else {
            $users = getAllUsers();
            echo json_encode($users);
        }
        break;

    case 'PUT':
        // Update user
        parse_str(file_get_contents("php://input"), $data);
        $user_id = $data['user_id'] ?? null;
        $username = $data['username'] ?? null;
        $email = $data['email'] ?? null;

        if ($user_id && $username && $email) {
            if (updateUser($user_id, $username, $email)) {
                echo json_encode(['status' => 'updated']);
            } else {
                echo json_encode(['error' => 'Update failed.']);
            }
        } else {
            echo json_encode(['error' => 'Missing fields.']);
        }
        break;

    case 'DELETE':
        // Delete user
        parse_str(file_get_contents("php://input"), $data);
        $user_id = $data['user_id'] ?? null;

        if ($user_id && deleteUser($user_id)) {
            echo json_encode(['status' => 'deleted']);
        } else {
            echo json_encode(['error' => 'Delete failed or missing user_id.']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request method']);
}
