<?php
if($_SERVER["REQUEST_METHOD"] === "POST")
{

    $commentId = $_POST['commentId'] ?? null;
    $userId = $_POST['userId'] ?? null;
    $deletionReason = $_POST['deletionReason'] ?? null;


    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;
    try{
        $db->queryFetch("CALL sp_Comments(3,?,NULL,NULL,?,?,NULL,NULL)",[
            $commentId,
            $deletionReason,
            $userId
        ]);
    }
    catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }

    if($result)
    {
        echo json_encode([
            'status' => true,
            'message' => "Comment deleted succesfully"
            ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'message' => $exception
            ]);
        return;
    }
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try{
        $DeletedComments = $db->queryFetchAll("CALL sp_Comments(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[]);
    }
    catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }

    if($result)
    {
        echo json_encode([
            'status' => true,
            'payload' => [
                "DeletedComments" => $DeletedComments
            ]
            ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'message' => $exception
            ]);
        return;
    }
}