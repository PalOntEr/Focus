<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/instructorReports.php';
$instructorReportsModel = new InstructorReportsModel();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $purchaseId = $_GET['purchaseId'] ?? null;
    $purchaseDate = isset($_GET['purchaseDate']) ? urldecode($_GET['purchaseDate']) : null;
    $modificationDate = isset($_GET['modificationDate']) ? urldecode($_GET['modificationDate']) : null;
    $userId = $_GET['userId'] ?? null;
    $courseId = $_GET['courseId'] ?? null;
    $levelId = $_GET['levelId'] ?? null;
    $paymentMethod = $_GET['paymentMethod'] ?? null;
    $paymentType = $_GET['paymentType'] ?? null;
    $paymentAmount = $_GET['paymentAmount'] ?? null;

    $result = true;

    try {
        $salesReport = $instructorReportsModel->getPerStudentSalesFiltered(
            $purchaseId,
            $purchaseDate,
            $modificationDate,
            $userId,
            $courseId,
            $levelId,
            $paymentMethod,
            $paymentType,
            $paymentAmount
        );
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