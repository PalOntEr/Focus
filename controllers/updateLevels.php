<?php

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['levelsCreated']) && isset($_POST['deletedLevels']))
{

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;


    $levelsCreated = json_decode($_POST['levelsCreated'], true);
    $deletedLevels = json_decode($_POST['deletedLevels'], true);
    
    try{
    if (is_array($levelsCreated)) {
        foreach ($levelsCreated as $index => $level) {
        $AlreadyCreated = $db->queryFetch("CALL sp_Levels(5,?,NULL,NULL,NULL,NULL,NULL,NULL)",[
            $level['levelId']
        ]);

        if($AlreadyCreated)
        {
            $db->queryFetch("CALL sp_Levels(2,?,NULL, NULL,?,?,?,?,NULL)",[
                $level['levelId'],
                $level['levelName'],
                $level['levelNumber'],
                $level['levelDescription'],
                $level['levelCost']
            ]);

            $videoFile = $_FILES['levelVideo'][$index];
                if ($videoFile['error'] === UPLOAD_ERR_OK) {
                    $videoDir = "videos/";
                    if (!is_dir($videoDir)) {
                        mkdir($videoDir, 0777, true);
                    }

                    $videoPath = $videoDir . uniqid() . "." .$videoFile['name'];
                    if (move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
                        // Save the video info in the database
                        $db->queryInsert("CALL sp_Contents(5,NULL,?,?,?,?)", [
                            $videoPath,
                            $videoFile['name'],
                            $videoFile['type'],
                            $level['levelId']
                        ]);
                }
            }
            $db->queryInsert("CALL sp_Contents(5,NULL,?,?,?,?)", [
                file_get_contents($_FILES['levelFile'][$index]),
                $_FILES['levelFile'][$index]['name'],
                $_FILES['levelFile'][$index]['type'],
                $level['levelId']
            ]);
        }
        else{
            $db->queryInsert("CALL sp_Levels(1,NULL,NULL,NULL,?,?,?,?,NULL)",[
                $level['levelName'],
                $level['levelNumber'],
                $level['levelDescription'],
                $level['levelCost']
            ]);

            $levelInfo = $db->queryFetch("CALL sp_Levels(5, NULL,NULL,NULL,?,?,NULL,NULL,NULL)",[
                $level['levelName'],
                $levelNumber['levelNumber']
            ]);

            $videoFile = $_FILES['levelVideo'][$index];
            if ($videoFile['error'] === UPLOAD_ERR_OK) {
                $videoDir = "videos/";
                if (!is_dir($videoDir)) {
                    mkdir($videoDir, 0777, true);
                }

                $videoPath = $videoDir . uniqid() . "." .$videoFile['name'];
                if (move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
                    // Save the video info in the database
                    $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)", [
                        $videoPath,
                        $videoFile['name'],
                        $videoFile['type'],
                        $levelInfo['levelId']
                    ]);
            }
        }
        $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)", [
            file_get_contents($_FILES['levelFile'][$index]),
            $_FILES['levelFile'][$index]['name'],
            $_FILES['levelFile'][$index]['type'],
            $levelInfo['levelId']
        ]);
        }
        }
    }

    if (is_array($deletedLevels)) {
    foreach ($deletedLevels as $level) {
            $db->queryFetch("CALL sp_level(3, ?,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[
                $level['levelId']
            ]);
        }
    }
    }catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }
    
    if($result)
    {
    echo json_encode([
        'status' => true,
        'payload' => "levels Updated Succesfully"
    ]);
    return;
    }
    else{
        echo json_encode([
            'status' => false,
            'error' => $exception
        ]);
        return;
    }
}