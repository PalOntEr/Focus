<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    header('Content-Type: application/json');
    try {
        if(!isset($_POST['categoryName']) || !isset($_POST['categoryDescription']) || !isset($_POST['userId'])) {
            throw new Exception('All fields are required');
        }
    }
    catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $e->getMessage()
            ]
        ]);
        return;
    }

    $name = $_POST['categoryName'];
    $desc = $_POST['categoryDescription'];
    $creatorId = $_POST['userId'];

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try {
        $categories = $db->queryFetch("CALL sp_Categories (1,NULL, ?, ?,?)", [
            $name,
            $desc,
            $creatorId
        ]);
    }
    catch (PDOException $e) {
        $result = false;
        $exception = $e;
    }


    if($result)
    {
        http_response_code(200);

        echo json_encode([
            'status' => true,
            'payload' => [
                'categories' => $categories
            ]
        ]);
        return;

    }else{
        http_response_code(400);
        echo json_encode([
        'status' => false,
        'payload' => [
            'error' => $exception->getMessage()
        ]
    ]);
    return;
    }

}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;

    try{
        $categories = $db->queryFetchAll("CALL sp_Categories(6,NULL,NULL,NULL,NULL)");
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
                'categories' => $categories
            ]
        ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $exception->getMessage()
            ]
        ]);
        return;
    }
}
?>