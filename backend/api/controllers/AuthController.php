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
                "message" => "User already exist",
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
        $user = $this->user->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $token = Jwt::encode($user['id']);
            return json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user" => $user,
                "token" => $token
            ]);
        }
        return json_encode([
            "status" => "error",
            "message" => "Invalid username or password"
        ]);
    }
}
