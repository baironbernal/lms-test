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

        if ($stmt->execute()) {
            $user_id = $this->db->conn->lastInsertId();

            $token = Jwt::encode($user_id);

            $stmt = $this->db->conn->prepare("UPDATE users SET token = :token WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $user_id);

            return $stmt->execute();
        }

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
