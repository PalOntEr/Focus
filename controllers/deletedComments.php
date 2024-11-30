<?php

require __DIR__.'/../models/entities/comments.php';

$commentModel = new CommentsModel();

if($_SERVER["REQUEST_METHOD"] === "POST")
{

    $commentId = $_POST['commentId'] ?? null;
    $userId = $_POST['userId'] ?? null;
    $deletionReason = $_POST['deletionReason'] ?? null;

    $result = true;
    try{
        $commentModel->removeComment($commentId, $deletionReason, $userId);
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
            'message' => "Comment deleted succesfully"
            ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'message' => $exception
            ]);
        return;
    }
}

if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $result = true;

    try{
        $DeletedComments = $commentModel->getDeletedComments();
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
                "DeletedComments" => $DeletedComments
            ]
            ]);
        return;
    }
    else{
        echo json_encode([
            'status' => false,
            'message' => $exception
            ]);
        return;
    }
}