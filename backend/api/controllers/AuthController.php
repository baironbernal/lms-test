<?php

require_once '../models/User.php';
require_once '../token/Jwt.php';


class AuthController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register($username, $email, $password)
    {
        $user = $this->user->findByUsername($username);
        if ($user) {
            return json_encode([
                "status" => "error",
                "message" => "User already exists",
            ]);
        }
        if ($this->user->register($username, $email, $password)) {
            return json_encode([
                "status" => "success",
                "message" => "Registration successful",
                "user" => $user
            ]);
        }
        return json_encode(["status" => "error", "message" => "Registration failed"]);
    }

    // Login a user
    public function login($username, $password)
    {
        // Find the user by username
        $user = $this->user->findByUsername($username);

        // Check if the user exists and the password is correct
        if ($user && password_verify($password, $user['password'])) {

            // Generate JWT token
            $user_id = $user['id'];
            $token = Jwt::encode($user_id);

            // Store the token in the database
            $this->user->storeToken($user_id, $token);

            // Return response with the token
            return json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user" => $user,
                "token" => $token,  // Include the token in the response
            ]);
        }

        // Return error if credentials are invalid
        return json_encode([
            "status" => "error",
            "message" => "Invalid username or password"
        ]);
    }

    public function logOut($token)
    {
        $user = $this->user->findByToken($token);

        if (!$user) {
            return json_encode([
                "status" => "error",
                "message" => "No user found with this token"
            ]);
        }

        if ($this->user->removeToken($user['id'])) {
            return json_encode([
                "status" => "success",
                "message" => "Logout completed"
            ]);
        }
    }
}
