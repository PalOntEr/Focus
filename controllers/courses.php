<?php
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['courseId']))
{
    $CourseId = $_GET['courseId'];
        
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try{
        $CourseFound = $db->queryFetch("CALL sp_Course(5,?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[
            $CourseId
        ]);

        if (isset($CourseFound['courseImage'])) {
                $CourseFound['courseImage'] = base64_encode($CourseFound['courseImage']);
            }

        $levels = $db->queryFetchAll("CALL sp_Levels(5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,?)",[
            $CourseId
        ]);

        foreach ($levels as &$level) {
            // Fetch content for the current level
            $contents = $db->queryFetchAll("CALL sp_Contents(4, NULL,NULL,NULL,?)", [
                $level['levelId']
            ]);
            foreach ($contents as &$content) {
                if (isset($content['file'])) {
                    $content['file'] = base64_encode($content['file']);
                }
            }
            unset($content);

            // Assign content to the current level
            $level['contents'] = $contents;
        
        }

        unset($level);

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
                'course' => $CourseFound,
                'levels' => $levels
            ]
        ]);
    }
    else
    {
        echo json_encode([
            'status' => false,
            'error' => $exception,
        ]);
    }
}