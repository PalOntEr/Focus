<?php
if($_SERVER["REQUEST_METHOD"] === "GET")
{
    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

$commentId = $_GET['comment_id'] ?? null;
$creationDate = isset($_GET['creation_date']) ? urldecode($_GET['creation_date']) : null;
$modificationDate = isset($_GET['modification_date']) ? urldecode($_GET['modification_date']) : null;
$deactivationDate = isset($_GET['deactivation_date']) ? urldecode($_GET['deactivation_date']) : null;
$comment = $_GET['comment'] ?? null;
$userId = $_GET['user_id'] ?? null;
$courseId = $_GET['course_id'] ?? null;
$rating = $_GET['rating'] ?? null;

if (!$commentId && !$courseId && !$userId) {
    echo json_encode([
        'status' => false,
        'message' => 'At least one of comment_id, course_id, or user_id must be provided.'
    ]);
    exit;
}

try {
    // Example: Call a stored procedure with the retrieved parameters
    $result = $db->queryFetchAll("CALL sp_Comments(5,?, ?, ?, ?, ?, ?, ?)", [
        $commentId,
        $creationDate,
        $deactivationDate,
        $comment,
        $userId,
        $courseId,
        $rating
    ]);

    // Return success response
    echo json_encode([
        'status' => true,
        'payload' => $result
    ]);

} catch (Exception $e) {
    // Handle any exceptions during the database operation
    echo json_encode([
        'status' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
}

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $comment = $_POST["comment"];
    $rating = $_POST["rating"];
    $userId = $_POST["userId"];
    $courseId = $_POST["courseId"];

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);
    
    $result = true;

    try{
        $db->queryInsert("CALL sp_Comments(1,NULL,NULL,NULL,?,?,?,?)",[
            $comment,
            $userId,
            $courseId,
            $rating
        ]);
    }catch(PDOException $e)
    {
        $result = false;
        $exception = $e;
    }

    if($result)
    {
        echo json_encode([
            "status" => true,
            "payload" =>[
                "message" => "Comment created succesfully"
            ]
        ]);
    }
    else{
        echo json_encode([
            "status" => false,
            "payload" =>[
                "message" => $exception
            ]
        ]);
    }
}