<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $purchaseId = $_GET['purchaseId'] ?? null;
    $purchaseDate = $_GET['purchaseDate'] ?? null;
    $modificationDate = $_GET['modificationDate'] ?? null;
    $userId = $_GET['userId'] ?? null;
    $courseId = $_GET['courseId'] ?? null;
    $levelId = $_GET['levelId'] ?? null;
    $paymentMethod = $_GET['paymentMethod'] ?? null;
    $paymentType = $_GET['paymentType'] ?? null;
    $paymentAmount = $_GET['paymentAmount'] ?? null;

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $salesReport = $db->queryFetchAll("CALL sp_Purchase(6, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $purchaseId,
            $purchaseDate,
            $modificationDate,
            $userId,
            $courseId,
            $levelId,
            $paymentMethod,
            $paymentType,
            $paymentAmount
        ]);
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'salesReport' => $salesReport
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