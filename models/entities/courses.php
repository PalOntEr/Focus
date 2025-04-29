<?php

require_once __DIR__.'/../../config/db.php';

class CourseModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getCourseById($CourseId) {
        $course = $this->db->queryFetch("CALL sp_Course(5,?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[
            $CourseId
        ]);
        return $course;
    }   

    public function getAllCourses() {
        $courses = $this->db->queryFetchAll("CALL sp_Course(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        foreach ($courses as &$course) {
            if (isset($course['courseImage'])) {
                $course['courseImage'] = base64_encode($course['courseImage']);
            }
        }
        return $courses;
    }

    public function getCoursesWithFilters($courseId, $creationDate = NULL, $modificationDate = NULL, $deactivationDate = NULL, $courseDescription = NULL, $courseTitle = NULL, $courseImage = NULL, $categoryId = NULL, $instructorId = NULL, $coursePrice = NULL) {
        $course = $this->db->queryFetchAll("CALL sp_Course(5, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $courseId,
            $creationDate,
            $modificationDate,
            $deactivationDate,
            $courseDescription,
            $courseTitle,
            $courseImage,
            $categoryId,
            $instructorId,
            $coursePrice
        ]);
        foreach ($course as &$c) {
            if (isset($c['courseImage'])) {
            $c['courseImage'] = base64_encode($c['courseImage']);
            }
        }
        return $course;
    }

    public function getTopSellerCourses() {
        $course = $this->db->queryFetchAll("CALL sp_Course(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        foreach ($course as &$c) {
            if (isset($c['courseImage'])) {
            $c['courseImage'] = base64_encode($c['courseImage']);
            }
        }
        return $course;
    }

    public function getTopRatedCourses() {
        $course = $this->db->queryFetchAll("CALL sp_Course(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        foreach ($course as &$c) {
            if (isset($c['courseImage'])) {
            $c['courseImage'] = base64_encode($c['courseImage']);
            }
        }
        return $course;
    }

    public function getTopRatedCoursesByUser($userId) {
        $course = $this->db->queryFetchAll("CALL sp_Course(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?, NULL)", [
            $userId
        ]);
        foreach ($course as &$c) {
            if (isset($c['courseImage'])) {
            $c['courseImage'] = base64_encode($c['courseImage']);
            }
        }
        return $course;
    }

    public function createCourse($creationDate, $modificationDate, $deactivationDate, $courseDescription, $courseTitle, $courseImage, $categoryId, $instructorId, $coursePrice) {
        return $this->db->queryInsert("CALL sp_Course(1, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $creationDate,
            $modificationDate,
            $deactivationDate,
            $courseDescription,
            $courseTitle,
            $courseImage,
            $categoryId,
            $instructorId,
            $coursePrice
        ]);
    }

    public function updateCourse($courseId, $creationDate, $modificationDate, $deactivationDate, $courseDescription, $courseTitle, $courseImage, $categoryId, $instructorId, $coursePrice) {
        return $this->db->queryFetch("CALL sp_Course(2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $courseId,
            $creationDate,
            $modificationDate,
            $deactivationDate,
            $courseDescription,
            $courseTitle,
            $courseImage,
            $categoryId,
            $instructorId,
            $coursePrice
        ]);
    }

    public function deleteCourse($courseId) {
        return $this->db->queryFetch("CALL sp_Course(3, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $courseId
        ]);
    }
}
?>