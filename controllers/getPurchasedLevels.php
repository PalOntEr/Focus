<?php

require __DIR__.'/../models/entities/purchasedLevels.php';
$purchaseModel = new PurchasedLevelsModel();

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $levelId = $_GET['level_id'] ?? null;
    $userId = $_GET['user_Id'] ?? null;
    $completed = $_GET['completed'] ?? null;

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try{
        $levelsFound = $purchaseModel->getPurchasedLevelsByUser($levelId, $userId, $completed);
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
                "PurchasedLevels" => $levelsFound
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