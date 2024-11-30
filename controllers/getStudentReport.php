<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/users.php';
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $result = true;

    try {
        $studentReport = $userModel->getStudentReport();
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'users' => $studentReport,
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