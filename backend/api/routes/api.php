<?php
require_once '../controllers/AuthController.php';

function handleRoutes()
{
    // Use POST data instead of GET parameters
    $action = $_POST['action'] ?? '';

    // Instantiate the AuthController
    $authController = new AuthController();

    switch ($action) {
        case 'register':
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['username'], $data['email'], $data['password'])) {
                echo $authController->register($data['username'], $data['email'], $data['password']);
            } else {
                echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            }
            break;

        case 'login':
            // Read POST body data for login
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['username'], $data['password'])) {
                echo $authController->login($data['username'], $data['password']);
            } else {
                echo json_encode(["status" => "error", "message" => "Missing username or password"]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
            break;
    }
}
