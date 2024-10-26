<?php

header('Content-Type: application/json');

// Get all users as a JSON object
if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        if($email && $password) {
            $users = $db->queryFetch("CALL sp_Users (4, NULL, NULL, NULL, NULL, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL)", [
                $email,
                $password
            ]);
            $_SESSION['user'] = $user;
        } 
        // else if($user) {
        //     $users = $db->queryFetchAll("CALL sp_Users (5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", []);
        // } 
        else {
            $users = $db->queryFetchAll("CALL sp_Users (5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", []);
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
    $missingFields = [];

    if (!isset($_POST['user'])) $missingFields[] = 'user';
    if (!isset($_POST['fullName'])) $missingFields[] = 'fullName';
    if (!isset($_POST['email'])) $missingFields[] = 'email';
    if (!isset($_POST['password'])) $missingFields[] = 'password';
    if (!isset($_POST['role'])) $missingFields[] = 'role';
    if (!isset($_POST['birthdate'])) $missingFields[] = 'birthdate';
    if (!isset($_FILES['profilePicture'])) $missingFields[] = 'profilePicture';
    if (!isset($_POST['gender'])) $missingFields[] = 'gender';

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
    
    $profilePicture = file_get_contents($_FILES['profilePicture']["tmp_name"]);


    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $db->queryInsert("CALL sp_Users (1, NULL, 'A', ?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?)", [
            $user,
            $fullName,
            $email,
            $password,
            $role,
            $birthdate,
            $profilePicture,
            $gender
        ]);
        
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
        $_SESSION["user"] = [
            "user" => $user,
            "fullName" => $fullName,
            "email" => $email,
            "role" => $role,
            "birthdate" => $birthdate,
            "profilePicture" => base64_encode($profilePicture),
            "gender" => $gender
        ];

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

    $profilePicture = file_get_contents($_FILES['profilePicture']["tmp_name"]); //SWAP THIS FOR A FILE UPLOAD

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
        $_SESSION["user"] = [
            "user" => $user,
            "fullName" => $fullName,
            "email" => $email,
            "role" => $role,
            "birthdate" => $birthdate,
            "profilePicture" => base64_encode($profilePicture),
            "gender" => $gender
        ];
        
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