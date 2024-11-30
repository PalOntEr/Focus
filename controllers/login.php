<?php 

require __DIR__.'/../models/entities/users.php';
$userModel = new UserModel();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');
    try {
        if(!isset($_POST['email']) || !isset($_POST['password'])) {
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

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = true;

    try {
        $tempUser = $userModel->getUserByEmail($email);

        if ($tempUser && password_verify($password, $tempUser['password'])){
            $user = $userModel->loginUserByEmail($email);

            $user['profilePicture'] = base64_encode($user['profilePicture']);            
        }
        else
        {
        $user = null;    
        }

    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if($result) {

        if(empty($user)) {
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'payload' => [
                    'error' => 'There was an error with your credentials'
                ]
            ]);
            return;
        }
        
        http_response_code(200);
        
        $_SESSION['user'] = $user;
        
        echo json_encode([
            'status' => true,
            'payload' => [
                'user' => $user
            ]
        ]);
        return;

    } else {
            http_response_code(400);
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
    session_destroy();
    require 'views/login.view.php';
}

?>