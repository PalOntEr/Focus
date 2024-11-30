<?php

require __DIR__.'/../models/entities/levels.php';
require __DIR__.'/../models/entities/contents.php';

$levelModel = new LevelModel();
$contentModel = new ContentsModel();

    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
    
        $levelId = $_GET['level_id'] ?? null;
        $creationDate = isset($_GET['creation_date']) ? urldecode($_GET['creation_date']) : null;
        $modificationDate = isset($_GET['modification_date']) ? urldecode($_GET['modification_date']) : null;
        $levelName = $_GET['level_name'] ?? null;
        $levelNumber = $_GET['level_number'] ?? null;
        $levelDescription = $_GET['level_description'] ?? null;
        $levelCost = $_GET['level_cost'] ?? null;
        $courseId = $_GET['course_id'] ?? null;
        try {
            $option = ($levelId === null && $creationDate === null && $modificationDate === null && $levelName === null && $levelNumber === null && $levelDescription === null && $levelCost === null && $courseId === null) ? 4 : 5;
    
            $levels = $levelModel->getLevelsWithFilters(
                $levelId, 
                $creationDate, 
                $modificationDate, 
                $levelName, 
                $levelNumber, 
                $levelDescription, 
                $levelCost, 
                $courseId, 
                true);

            if (empty($levels)) {
                echo json_encode([
                    'status' => false,
                    'payload' => [
                        'error' => 'No levels found'
                    ]
                ]);
                return;
            } else {
                echo json_encode([
                    'status' => true,
                    'payload' => [
                        'levels' => $levels
                    ]
                ]);
                return;
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'payload' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

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
        $levelModel->createLevel(
            $levelName, 
            $levelNumber, 
            $levelDescription, 
            $levelCost, 
            $courseId);

            
        $levelInfo = $levelModel->getLevelInfo($levelName, $levelNumber);
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
            $contentModel->insertContent(
                base64_encode($targetFilePath),
                $_FILES['levelVideo']['name'],
                ".mp4",
                $levelInfo["levelId"]
            );
            
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
        $contentModel->insertContent(
            $file,
            $_FILES['levelFile']['name'],
            $fileType['type'],
            $levelInfo["levelId"]
        );
        
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