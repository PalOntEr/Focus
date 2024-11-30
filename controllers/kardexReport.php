<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $startDate = isset($_GET['startDate']) ? urldecode($_GET['startDate']) : null;
    $accessDate = isset($_GET['accessDate']) ? urldecode($_GET['accessDate']) : null;
    $completionDate = isset($_GET['completionDate']) ? urldecode($_GET['completionDate']) : null;
    $userId = $_GET['userId'] ?? null;
    $courseId = $_GET['courseId'] ?? null;
    $category = $_GET['categoryId'] ?? null;

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $kardexReport = $db->queryFetchAll("CALL sp_Kardex(6, ?, ?, ?, ?, ?, ?)", [
            $startDate,
            $accessDate,
            $completionDate,
            $userId,
            $courseId,
            $category
        ]);
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'kardexReport' => $kardexReport,
                'params' => [
                    'startDate' => $startDate,
                    'accessDate' => $accessDate,
                    'completionDate' => $completionDate,
                    'userId' => $userId,
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