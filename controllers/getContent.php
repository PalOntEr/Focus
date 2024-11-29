<?php

if($_SERVER['REQUEST_METHOD'] === "GET")
{
            
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $levelId = $_GET['level_id'] ?? null;

    try{
        $contents = $db->queryFetchAll("CALL sp_Contents(4, NULL,NULL,NULL, NULL, ?)", [
            $levelId
        ]);

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