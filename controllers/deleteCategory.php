<?php

require __DIR__.'/../models/entities/categories.php';

$categoriesModel = new CategoriesModel();

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    header('Content-Type: application/json');
    try {
        if(!isset($_GET['categoryId'])) {
            throw new Exception('CategoryId is required');
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

    $categoryId = $_GET['categoryId'];

    $result = true;

    try {
        $categories = $categoriesModel->deleteCategory($categoryId);
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
                'message' => "Category Deleted succesfully"
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
?>