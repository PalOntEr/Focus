<?php

header('Content-Type: application/json');

// Get all users as a JSON object
if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $user = $_POST['user'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        if($user && $password) {
            $users = $db->queryFetch("CALL sp_Users (4, NULL, NULL, ?, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL)", [
                $user,
                $password
            ]);
            $_SESSION['user'] = $user;
        } 
        // else if($user) {
        //     $users = $db->queryFetchAll("CALL sp_Users (5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", []);
        // } 
        else {
            $users = $db->queryFetch("CALL sp_Users (5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", []);
        }
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
        
        echo json_encode([
            'status' => true,
            'payload' => [
                'users' => $users
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
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if(!isset($_POST['user']) || !isset($_POST['fullName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['role']) || !isset($_POST['birthdate']) || !isset($_FILES['profilePicture']) || !isset($_POST['gender'])) {
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
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    $profilePicture = $_FILES['profilePicture']; //SWAP THIS FOR A FILE UPLOAD

    $pictureRoute = __DIR__.'/../public/images/'.$profilePicture['name'];

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $db->queryFetch("CALL sp_Users (1, NULL, 'A', ?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?)", [
            $user,
            $fullName,
            $email,
            $password,
            $role,
            $birthdate,
            $pictureRoute,
            $gender
        ]);
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
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
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $_PATCH);

    try {
        if(!isset($_PATCH['userId'])) {
            throw new Exception('User ID is required');
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

    $user = $_PATCH['user'] ?? null;
    $fullName = $_PATCH['fullName'] ?? null;
    $email = $_PATCH['email'] ?? null;
    $password = $_PATCH['password'] ?? null;
    $role = $_PATCH['role'] ?? null;
    $birthdate = $_PATCH['birthdate'] ?? null;
    $gender = $_PATCH['gender'] ?? null;

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $db->queryFetch("CALL sp_Users (2, NULL, 'A', ?, ?, ?, ?, NULL, NULL, NULL, ?, ?, ?)", [
            $user,
            $fullName,
            $email,
            $password,
            $role,
            $birthdate,
            $gender
        ]);
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
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
    }
}
?>