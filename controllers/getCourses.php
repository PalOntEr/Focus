<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

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

    try {
        $option = ($courseId === null && $creationDate === null && $modificationDate === null && $categoryId === null && $coursePrice === null && $courseTitle === null && $courseDescription === null && $instructorId === null && $deactivationDate === null && $courseImage === null) ? 4 : 5;

        $courses = $db->queryFetchAll("CALL sp_Course($option, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
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


        foreach ($courses as &$course) {
            if (isset($course['courseImage'])) {
                $course['courseImage'] = base64_encode($course['courseImage']);
            }
        }
        unset($course);

        if (empty($courses)) {
            echo json_encode([
            'status' => false,
            'payload' => [
                'error' => 'No courses found'
            ]
            ]);
            return;
        }else{
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