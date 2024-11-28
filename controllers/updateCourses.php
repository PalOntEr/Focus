<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $missingFields = [];

    if (!isset($_POST['course_Id'])) $missingFields[] = 'course_Id';
    if (!isset($_POST['title'])) $missingFields[] = 'title';
    if (!isset($_POST['description'])) $missingFields[] = 'description';
    if (!isset($_POST['category'])) $missingFields[] = 'category';
    if (!isset($_FILES['courseImage'])) $missingFields[] = 'courseImage';
    if (!isset($_POST['oneTimeAmount'])) $missingFields[] = 'oneTimeAmount';


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

    $courseId = $_POST['course_Id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $coursePrice = $_POST['oneTimeAmount'];
    $courseImage = file_get_contents($_FILES['courseImage']["tmp_name"]);
    
    if (empty($coursePrice) || $coursePrice === 'null') {
        $coursePrice = NULL;  // This will pass as a NULL value in the SQL query
    }

    try{
        $db->queryInsert("CALL sp_Course(2,?,NULL,NULL,NULL, ?,?,?,?,NULL, ?)", [
            $courseId,
            $description,
            $title,
            $courseImage,
            $category,
            $coursePrice
        ]);
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
                'message' => 'Course Updated Succesfully'
            ]
        ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => $exception
            ]
        ]);
        return;
    }
}