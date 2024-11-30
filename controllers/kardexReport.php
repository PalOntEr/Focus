<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/kardex.php';
$kardexModel = new KardexModel();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $startDate = isset($_GET['startDate']) ? urldecode($_GET['startDate']) : null;
    $accessDate = isset($_GET['accessDate']) ? urldecode($_GET['accessDate']) : null;
    $completionDate = isset($_GET['completionDate']) ? urldecode($_GET['completionDate']) : null;
    $userId = $_GET['userId'] ?? null;
    $courseId = $_GET['courseId'] ?? null;
    $category = $_GET['categoryId'] ?? null;

    $result = true;

    try {
        $kardexReport = $kardexModel->getKardexWithFilters(
            $startDate,
            $accessDate,
            $completionDate,
            $userId,
            $courseId,
            $category
        );
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