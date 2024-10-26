<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');
    try {
        if(!isset($_POST['user']) || !isset($_POST['password'])) {
            throw new Exception('All fields are required');
        }
    }
    catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $e->getMessage()
            ]
        ]);
        return;
    }

    $user = $_POST['user'];
    $password = $_POST['password'];

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $user = $db->queryFetch("CALL sp_Users (4, NULL, NULL, ?, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $user,
            $password
        ]);
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
        if(!session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['user'] = $user;
        }
        
        echo json_encode([
            'status' => true,
            'payload' => [
                'user' => $user
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
else if($_SERVER['REQUEST_METHOD'] === 'GET') {
    require 'views/login.view.php';
}

?>