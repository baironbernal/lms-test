<?php

require_once '../models/User.php';
require_once '../models/Course.php';
require_once '../token/Jwt.php';

class CourseController
{
    private $user;
    private $course;

    public function __construct()
    {
        $this->user = new User();
        $this->course = new Course();
    }

    // Utility function to check if the token is valid
    private function checkToken($token)
    {
        $user = $this->user->findByToken($token);
        if (!$user) {
            return json_encode([
                "status" => "error",
                "message" => "Invalid token. Please authenticate."
            ]);
        }
        return $user; // Return the user if token is valid
    }

    // CREATE: Add a new course
    public function create($token, $course_name, $course_description)
    {
        $user = $this->checkToken($token);
        if (isset($user["status"])) {
            return $user; // Return error message if token is invalid
        }

        // Proceed with creating the course
        if ($this->course->create($course_name, $course_description)) {
            return json_encode([
                "status" => "success",
                "message" => "Course created successfully."
            ]);
        }

        return json_encode([
            "status" => "error",
            "message" => "Failed to create course."
        ]);
    }

    // READ: Get all courses
    public function index($token)
    {
        $user = $this->checkToken($token);
        if (isset($user["status"])) {
            return $user; // Return error message if token is invalid
        }

        $courses = $this->course->index();
        if (empty($courses)) {
            return json_encode([
                "status" => "error",
                "message" => "No courses found."
            ]);
        }

        return json_encode([
            "status" => "success",
            "courses" => $courses
        ]);
    }

    // READ: Get a specific course by ID
    public function getById($token, $course_id)
    {
        $user = $this->checkToken($token);
        if (isset($user["status"])) {
            return $user; // Return error message if token is invalid
        }

        $course = $this->course->getById($course_id);
        if (!$course) {
            return json_encode([
                "status" => "error",
                "message" => "Course not found."
            ]);
        }

        return json_encode([
            "status" => "success",
            "course" => $course
        ]);
    }

    // UPDATE: Update course details
    public function update($token, $course_id, $course_name, $course_description)
    {
        $user = $this->checkToken($token);
        if (isset($user["status"])) {
            return $user; // Return error message if token is invalid
        }

        if ($this->course->update($course_id, $course_name, $course_description)) {
            return json_encode([
                "status" => "success",
                "message" => "Course updated successfully."
            ]);
        }

        return json_encode([
            "status" => "error",
            "message" => "Failed to update course."
        ]);
    }

    // DELETE: Delete a course by ID
    public function delete($token, $course_id)
    {
        $user = $this->checkToken($token);
        if (isset($user["status"])) {
            return $user; // Return error message if token is invalid
        }

        if ($this->course->delete($course_id)) {
            return json_encode([
                "status" => "success",
                "message" => "Course deleted successfully."
            ]);
        }

        return json_encode([
            "status" => "error",
            "message" => "Failed to delete course."
        ]);
    }
}
