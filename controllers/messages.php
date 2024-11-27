<?php

header('Content-Type: application/json');

// Get all messages as a JSON object
if($_SERVER['REQUEST_METHOD'] == 'GET') {

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    $senderId = $_GET['sender_id'] ?? null;
    $receiverId = $_GET['receiver_id'] ?? null;
    $getChat = $_GET['get_chat'] ?? null;

    if ($getChat) {
        try {
            $chats = $db->queryFetchAll("CALL sp_Chats(1, ?, ?)", [
                ($getChat === 'true' ? $senderId : $receiverId),
                ($getChat === 'true' ? $receiverId : $senderId)
            ]);
            echo json_encode([
                'status' => true,
                'payload' => [
                    'chats' => $chats
                ]
            ]);
            return;
        } catch (PDOException $e) {
            $result = false;
            $exception = $e;
        }
    }

    try {
        $messages = $db->queryFetchAll("CALL sp_Messages(2, NULL, ?, ?, NULL)", [
            $senderId,
            $receiverId
        ]);
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'messages' => $messages
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
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $message = $_POST['message'] ?? null;
    $senderId = $_POST['sender_id'] ?? null;
    $receiverId = $_POST['receiver_id'] ?? null;

    if (!$message || !$senderId || !$receiverId) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => 'Missing message, sender_id or receiver_id'
            ]
        ]);
        return;
    }

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $db->queryInsert("CALL sp_Messages(1, NULL, ?, ?, ?)", [
            $senderId,
            $receiverId,
            $message
        ]);
    } catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }

    if ($result) {
        echo json_encode([
            'status' => true,
            'payload' => [
                'message' => $message,
                'sender_id' => $senderId,
                'receiver_id' => $receiverId
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
else {
    echo json_encode([
        'status' => false,
        'payload' => [
            'error' => 'Method not allowed'
        ]
    ]);
}

?>