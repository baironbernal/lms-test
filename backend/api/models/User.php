<?php

require_once '../token/Jwt.php';
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($username, $email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        // Only insert the user into the database, no token needed here
        return $stmt->execute();
    }

    // Login function to authenticate the user and generate a JWT token
    public function login($username, $password)
    {
        // Find the user by username
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists, verify password
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, generate JWT token
            $user_id = $user['id'];
            $token = Jwt::encode($user_id);

            // Store the token in the database
            $this->storeToken($user_id, $token);

            // Return the token to the user
            return $token;
        }

        // Invalid credentials
        return false;
    }

    // Find user by username
    public function findByUsername($username)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Store token in the database
    public function storeToken($userId, $token)
    {
        $stmt = $this->db->conn->prepare("UPDATE users SET token = :token WHERE id = :userId");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    // Remove token from the database (logout)
    public function removeToken($userId)
    {
        $stmt = $this->db->conn->prepare("UPDATE users SET token = NULL WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    // Find user by token
    public function findByToken($token)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
