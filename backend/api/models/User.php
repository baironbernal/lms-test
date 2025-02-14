<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Register a new user
    public function register($username, $email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        return $stmt->execute();
    }

    // Find user by username
    public function findByUsername($username)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
