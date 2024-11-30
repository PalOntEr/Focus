<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require __DIR__.'/../models/entities/courses.php';
    $courseModel = new CourseModel();

    $courseId = $_GET['course_id'] ?? null;
    $creationDate = isset($_GET['creation_date']) ? urldecode($_GET['creation_date']) : null;
    $modificationDate = isset($_GET['modification_date']) ? urldecode($_GET['modification_date']) : null;
    $categoryId = $_GET['category_id'] ?? null;
    $coursePrice = $_GET['course_price'] ?? null;
    $courseTitle = $_GET['course_title'] ?? null;
    $courseDescription = $_GET['course_description'] ?? null;
    $instructorId = $_GET['instructor_id'] ?? null;
    $deactivationDate = isset($_GET['deactivation_date']) ? urldecode($_GET['deactivation_date']) : null;
    $courseImage = $_GET['course_image'] ?? null;
    $getTopSellers = $_GET['top_sellers'] ?? null;
    $getTopRating = $_GET['top_rating'] ?? null;
    $getUserRatedCourses = $_GET['user_rated_courses'] ?? null;

    try {
        if($getTopSellers) {
            $courses = $courseModel->getTopSellerCourses();
        }
        if ($getTopRating) {
            $courses = $courseModel->getTopRatedCourses();
        }
        if ($getUserRatedCourses) {
            $courses = $courseModel->getTopRatedCoursesByUser($instructorId);
        }
        else{
            $courses = $courseModel->getCoursesWithFilters(
                $courseId,
                $creationDate,
                $modificationDate,
                $categoryId,
                $coursePrice,
                $courseTitle,
                $courseDescription,
                $instructorId,
                $deactivationDate,
                $courseImage,
                $getTopSellers,
                $getTopRating,
                $getUserRatedCourses
            );
        }

        if (empty($courses)) {
            echo json_encode([
                'status' => false,
                'payload' => [
                    'error' => 'No courses found'
                ]
            ]);
            return;
        } else {
            echo json_encode([
                'status' => true,
                'payload' => [
                    'courses' => $courses
                ]
            ]);
            return;
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $e->getMessage()
            ]
        ]);
    }

} else {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'payload' => [
            'error' => 'Method not allowed'
        ]
    ]);
}
?>
