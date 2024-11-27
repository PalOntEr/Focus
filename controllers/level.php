<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $missingFields = [];

        if (!isset($_POST['levelName'])) $missingFields[] = 'levelName';
        if (!isset($_POST['levelDescription'])) $missingFields[] = 'levelDescription';
        if (!isset($_FILES['levelVideo'])) $missingFields[] = 'levelVideo';
        if (!isset($_FILES['levelFile'])) $missingFields[] = 'levelFile';
        if (!isset($_POST['levelCost'])) $missingFields[] = 'levelCost';
    
    
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

        require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

        $levelName = $_POST['levelName'];
        $levelDescription = $_POST['levelDescription'];
        $levelNumber = $_POST['levelNumber'];
        $courseId = $_POST['CourseId'];
        $levelCost = $_POST['levelCost'];

        // Check if levelCost is empty or 'null' and set it to actual SQL NULL
        if (empty($levelCost) || $levelCost === 'null') {
            $levelCost = NULL;  // This will pass as a NULL value in the SQL query
        }
    try{
        $db->queryInsert("CALL sp_Levels(1,NULL,NULL,NULL,?,?,?,?,?)",[
            $levelName,
            $levelNumber,
            $levelDescription,
            $levelCost,
            $courseId
        ]);

        $levelInfo = $db->queryFetch("CALL sp_Levels(5, NULL,NULL,NULL,?,?,NULL,NULL,NULL)",[
            $levelName,
            $levelNumber
        ]);
    }
    catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }

    $fileType = $_FILES['levelFile'];
    $file = file_get_contents($_FILES['levelFile']['tmp_name']);

    define('BASE_PATH', __DIR__);

    $targetDir = "videos/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $video_ext = explode(".", $_FILES['levelVideo']['name']);
    $video_ext = strtolower(end($video_ext));
    $fileName = uniqid()  . "." . $video_ext;
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['levelVideo']['tmp_name'], $targetFilePath)) {
        try{
            $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?)",[
                base64_encode($targetFilePath),
                ".mp4",
                $levelInfo["levelId"]
            ]);
            
        }catch(PDOException $e)
        {
            $result = false;
            $exception = $e;
        }
    }
    else{
        $result = false;
        $exception = "El archivo no pudo ser movido al servidor";
    }

    try{
        $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?)",[
            $file,
            $fileType['type'],
            $levelInfo["levelId"]
        ]);
        
    }catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }

    if($result)
    {
    echo json_encode([
        'status' => true
    ]);
    return;
    }
    else{
        echo json_encode([
            'status' => false,
            'error' => $exception,
            'levelInfo' => $levelInfo
        ]);
        return;
    }
}
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    require 'views/level.view.php';
?>