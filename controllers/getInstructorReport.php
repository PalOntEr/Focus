<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/users.php';
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $result = true;

    try {
        $instructorReport = $userModel->getInstructorReport();
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'users' => $instructorReport,
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