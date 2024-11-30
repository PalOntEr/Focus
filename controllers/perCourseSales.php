<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $instructorId = $_GET['instructorId'] ?? null;
    $creationDate = isset($_GET['creationDate']) ? urldecode($_GET['creationDate']) : null;
    $modificationDate = isset($_GET['modificationDate']) ? urldecode($_GET['modificationDate']) : null;
    $categoryId = $_GET['categoryId'] ?? null;
    $courseId = $_GET['courseId'] ?? null;

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $salesReport = $db->queryFetchAll("CALL sp_InstructorReports(1, ?, ?, ?, ?, ?)", [
            $instructorId,
            $creationDate,
            $modificationDate,
            $categoryId,
            $courseId
        ]);
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'salesReport' => $salesReport,
                'params' => [
                    'instructorId' => $instructorId,
                    'creationDate' => $creationDate,
                    'modificationDate' => $modificationDate,
                    'categoryId' => $categoryId,
                    'courseId' => $courseId
                ]
            ]
        ]);
        return;
    } else {
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $exception->getMessage()
            ]
        ]);
        return;
    }
}
?>