<?php

header('Content-Type: application/json');

require __DIR__.'/../models/entities/contents.php';
$contentsModel = new ContentsModel();

if($_SERVER['REQUEST_METHOD'] === "GET")
{

    $levelId = $_GET['level_id'] ?? null;

    try{
        $contents = $contentsModel->getContentsOfLevel($levelId);   

            foreach ($contents as &$content) {
                if (isset($content['file'])) {
                    $content['file'] = base64_encode($content['file']);
                }
            }

    if(empty($contents))
    {
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => "No content for the level was found"
            ]
        ]);
    }
    else{
        echo json_encode([
            'status' => true,
            'payload' => [
                'content' => $contents
            ]
        ]);
    }
    }catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'payload' => [
            'error' => $e->getMessage()
        ]
    ]);
}
    unset($level);

}