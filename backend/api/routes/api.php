<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/CourseController.php';

function handleRoutes()
{
    $inputData = json_decode(file_get_contents("php://input"), true);
    $action = $inputData['action'] ?? '';

    // Initialize controllers
    $authController = new AuthController();
    $courseController = new CourseController();
    $responseData = [];

    switch ($action) {
        case 'register':
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['username'], $data['email'], $data['password'])) {
                // Call the register method and store response in data
                $responseData = $authController->register($data['username'], $data['email'], $data['password']);
            } else {
                $responseData = ["status" => "error", "message" => "Missing required fields"];
            }
            break;

        case 'login':
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['username'], $data['password'])) {
                $responseData = $authController->login($data['username'], $data['password']);
            } else {
                $responseData = ["status" => "error", "message" => "Missing username or password"];
            }
            break;
        case 'logout':
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['token'])) {
                $responseData = $authController->logOut($data['token']);
            } else {
                $responseData = ["status" => "error", "message" => "Is not possible Logout"];
            }
            break;

        case 'create_course':
            // Extract the token and course data from the request
            $data = json_decode(file_get_contents("php://input"), true);
            $token = $data['token'] ?? '';
            $course_name = $data['course_name'] ?? '';
            $course_description = $data['course_description'] ?? '';

            if ($token && $course_name && $course_description) {
                // Call the course controller to create the course
                $responseData = $courseController->create($token, $course_name, $course_description);
            } else {
                $responseData = ["status" => "error", "message" => "Missing token or course data"];
            }
            break;

        case 'index_courses':
            // Extract the token from the request
            $data = json_decode(file_get_contents("php://input"), true);
            $token = $data['token'] ?? '';

            if ($token) {
                // Call the course controller to fetch all courses
                $responseData = $courseController->index($token);
            } else {
                $responseData = ["status" => "error", "message" => "Missing token"];
            }
            break;

        case 'find_course':
            // Extract the token and course ID from the request
            $data = json_decode(file_get_contents("php://input"), true);
            $token = $data['token'] ?? '';
            $course_id = $data['course_id'] ?? '';

            if ($token && $course_id) {
                // Call the course controller to fetch the course by ID
                $responseData = $courseController->getById($token, $course_id);
            } else {
                $responseData = ["status" => "error", "message" => "Missing token or course ID"];
            }
            break;

        case 'delete_course':
            // Extract the token and course ID from the request
            $data = json_decode(file_get_contents("php://input"), true);
            $token = $data['token'] ?? '';
            $course_id = $data['course_id'] ?? '';

            if ($token && $course_id) {
                // Call the course controller to delete the course by ID
                $responseData = $courseController->delete($token, $course_id);
            } else {
                $responseData = ["status" => "error", "message" => "Missing token or course ID"];
            }
            break;

        default:
            $responseData = ["status" => "error", "message" => "Invalid action"];
            break;
    }

    // Output the response in JSON format
    echo json_encode($responseData);
}
