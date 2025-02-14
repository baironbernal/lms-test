<?php
class Course
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($course_name, $course_description)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO courses (course_name, course_description) VALUES (:course_name, :course_description)");
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':course_description', $course_description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function index()
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM courses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($course_id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($course_id, $course_name, $course_description)
    {
        $stmt = $this->db->conn->prepare("UPDATE courses SET course_name = :course_name, course_description = :course_description WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':course_description', $course_description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($course_id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
