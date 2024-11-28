<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        require __DIR__.'/../config/db.php';
        $config = require __DIR__.'/../config/config.php';
    
        $db = new Database($config['database']);
    
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
    
            $levels = $db->queryFetchAll("CALL sp_Levels($option, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $levelId,
                $creationDate,
                $modificationDate,
                $levelName,
                $levelNumber,
                $levelDescription,
                $levelCost,
                $courseId
            ]);
    
            foreach ($levels as &$level) {
                $contents = $db->queryFetchAll("CALL sp_Contents(4, NULL,NULL,NULL, NULL, ?)", [
                    $level['levelId']
                ]);
                $level['contents'] = $contents;
            }
    
            foreach ($levels as &$level) {
                if (isset($level['contents'])) {
                    foreach ($level['contents'] as &$content) {
                        if (isset($content['contentData'])) {
                            $content['contentData'] = base64_decode($content['contentData']);
                        }
                    }
                    unset($content);
                }
            }
            unset($level);
    
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
            $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)",[
                base64_encode($targetFilePath),
                $_FILES['levelVideo']['name'],
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
        $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)",[
            $file,
            $_FILES['levelFile']['name'],
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