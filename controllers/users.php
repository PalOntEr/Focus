<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/users.php';
$userModel = new UserModel();

// Get all users as a JSON object
if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    $result = true;

    try {
        if($email && $password) {
            $users = $userModel->getUserByEmailAndPassword($email, $password);
            $_SESSION['user'] = $users;
        } else {
            $users = $userModel->getAllUsers();
        }
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {
        // foreach ($users as &$user) {
        //     if (isset($user['profilePicture'])) {
        //         $user['profilePicture'] = base64_encode($user['profilePicture']);
        //     }
        // }

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
    if (!isset($_POST['isUpdating'])) $missingFields[] = 'isUpdating';

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

    $username = $_POST['user'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $isUpdating = $_POST['isUpdating'];

    $profilePicture = file_get_contents($_FILES['profilePicture']["tmp_name"]);

    $result = true;

    try {
        if ($isUpdating == "false") {
            if ($password) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            $userModel->createUser($username, $fullName, $email, $password, $role, $birthdate, $profilePicture, $gender);
            $user = $userModel->getUserByEmail($email);
            // $user['profilePicture'] = base64_encode($user['profilePicture']);
        } else {
            $user = $userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                if ($password) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                }
                $userModel->updateUser($user["userId"], $username, $fullName, $email, $password, $role, $birthdate, $profilePicture, $gender);
                $user = $userModel->getUserByEmail($email);
                // $user['profilePicture'] = base64_encode($user['profilePicture']);
            }
        }
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        $_SESSION["user"] = [
            "userId" => $user["userId"],
            "username" => $username,
            "fullName" => $fullName,
            "email" => $email,
            "role" => $role,
            "birthdate" => $birthdate,
            "profilePicture" => $user['profilePicture'],
            "gender" => $gender,
            "creationDate" => $user['creationDate']
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
else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
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

    $profilePicture = file_get_contents($_FILES['profilePicture']["tmp_name"]); //SWAP THIS FOR A FILE UPLOAD

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;
    try {
        $user = $db->queryFetch("CALL sp_Users (5, NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)", [
            $email
        ]);

        if ($user && password_verify($password, $user['password'])){
            if ($password) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            $db->queryFetch("CALL sp_Users (2, NULL, 'A', ?, ?, ?, ?, NULL, NULL, NULL, ?, ?, ?)", [
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