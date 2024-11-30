<?php
if($_SERVER["REQUEST_METHOD"] === "POST")
{
    
    $levelId = $_POST['level_Id'] ?? null;
    $userId = $_POST['user_Id'] ?? null;
    $completed = $_POST['completed'] ?? null;

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try{
        $db->queryFetch("CALL sp_PurchasedLevels(1,?,?,?)",[
            $levelId,
            $userId,
            $completed
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
            "status" => true,
            "payload" => [
                "message" => "PurchasedLevel Completed Succesfully"
            ]
            ]);
    }
    else{
        echo json_encode([
            "status" => false,
            "error" => $exception
            ]);
    }

}