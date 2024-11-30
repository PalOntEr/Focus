<?php
if($_SERVER["REQUEST_METHOD"] === "POST")
{
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;


    $videoFile = $_FILES['videoFile'] ?? null;
    $file = $_FILES['file'] ?? null;
    $levelNumber = $_POST['levelNumber'];
    $courseId = $_POST['courseId'];

    try{
        $LevelRef = $db->queryFetch("CALL sp_Levels(5, NULL, NULL,NULL,NULL,?, NULL,NULL, ?,NULL,NULL)",[
            $levelNumber,
            $courseId
        ]);
        
        
        if(isset($videoFile))
        {
            $db->queryFetch("CALL sp_Contents(6,NULL,NULL,NULL,?,?)",[
                ".mp4",
                $LevelRef["levelId"]
            ]);
            $targetDir = "videos/";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $video_ext = explode(".", $_FILES['videoFile']['name']);
            $video_ext = strtolower(end($video_ext));
            $fileName = uniqid()  . "." . $video_ext;
            $targetFilePath = $targetDir . $fileName;

                if (move_uploaded_file($_FILES['videoFile']['tmp_name'], $targetFilePath)) {
                    try{
                        $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)",[
                            base64_encode($targetFilePath),
                            $_FILES['videoFile']['name'],
                            ".mp4",
                            $LevelRef["levelId"]
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
        }

        if(isset($file))
        {
            $db->queryFetch("CALL sp_Contents(6,NULL,NULL,NULL,?,?)",[
                $file["type"],
                $LevelRef["levelId"]
            ]);
            $fileType = $_FILES['file'];
            $file = file_get_contents($_FILES['file']['tmp_name']);
        
            $db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)",[
                $file,
                $_FILES['file']['name'],
                $fileType['type'],
                $LevelRef["levelId"]
            ]);
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
            'result' => "Content Updated Succesfully", 
        ]);
        return;
    }
    else
    {
        echo json_encode([
            'status' => false,
            'error' => $exception, 
        ]);
        return;
    }
}