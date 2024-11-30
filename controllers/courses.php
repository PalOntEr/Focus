<?php

require __DIR__.'/../models/entities/courses.php';
require __DIR__.'/../models/entities/levels.php';
require __DIR__.'/../models/entities/contents.php';

$courseModel = new CourseModel();
$levelModel = new LevelModel();
$contentModel = new ContentsModel();

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['courseId']))
{
    $CourseId = $_GET['courseId'];

    $result = true;

    try{
        $CourseFound = $courseModel->getCourseById($CourseId);

        if (isset($CourseFound['courseImage'])) {
                $CourseFound['courseImage'] = base64_encode($CourseFound['courseImage']);
            }

        $levels = $levelModel->getLevelByCourseId(
            $CourseId
        );

        foreach ($levels as &$level) {
            // Fetch content for the current level
            $contents = $contentModel->getContentsOfLevel($level['levelId']);
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