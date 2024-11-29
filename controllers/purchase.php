<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $missingFields = [];

    if (!isset($_POST['purchaseDate'])) $missingFields[] = 'purchaseDate';
    if (!isset($_POST['userId'])) $missingFields[] = 'userId';
    if (!isset($_POST['courseId'])) $missingFields[] = 'courseId';
    if (!isset($_POST['levelId'])) $missingFields[] = 'levelId';
    if (!isset($_POST['paymentMethod'])) $missingFields[] = 'paymentMethod';
    if (!isset($_POST['paymentType'])) $missingFields[] = 'paymentType';
    if (!isset($_POST['paymentAmount'])) $missingFields[] = 'paymentAmount';

    if (!empty($missingFields)) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => 'All fields are required',
                'missingFields' => $missingFields
            ]
        ]);
        return;
    }

    $purchaseDate = $_POST['purchaseDate'];
    $userId = $_POST['userId'];
    $courseId = $_POST['courseId'];
    $levelId = $_POST['levelId'];
    $paymentMethod = $_POST['paymentMethod'];
    $paymentType = $_POST['paymentType'];
    $paymentAmount = $_POST['paymentAmount'];

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $db->queryInsert("CALL sp_Purchase (1, NULL, ?, ?, ?, ?, ?, ?, ?)", [
            $purchaseDate,
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
                'message' => 'Purchase made successfully'
            ]
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $exception->getMessage()
            ]
        ]);
    }
}
?>