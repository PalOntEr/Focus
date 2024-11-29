<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{

    require __DIR__.'/../config/db.php';
    $config = require __DIR__.'/../config/config.php';

    $db = new Database($config['database']);

    $result = true;


    $levelsCreated = json_decode($_POST['LevelsCreated'], true);
    $deletedLevels = json_decode($_POST['deletedLevels'], true);
    
    try{
    if (is_array($levelsCreated)) {
        foreach ($levelsCreated as $index => $level) {
        $AlreadyCreated = $db->queryFetchAll("CALL sp_Levels(5,?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[
            $level['levelId'] === '' ? NULL : $level['levelId']
        ]);

        if(count($AlreadyCreated) == 1)
        {
            $db->queryFetch("CALL sp_Levels(2,?,NULL, NULL,?,?,?,?,?,NULL)",[
                $level['levelId'],
                $level['levelName'],
                $level['levelNumber'],
                $level['levelDescription'],
                $level['levelCost'] === '' ? NULL : $level['levelCost'],
                $level['levelCourse']
            ]);
        }
        else{
            $db->queryInsert("CALL sp_Levels(1,NULL,NULL,NULL,?,?,?,?,?,NULL)",[
                $level['levelName'],
                $level['levelNumber'],
                $level['levelDescription'],
                $level['levelCost'] === '' ? NULL : $level['levelCost'],
                $level['levelCourse']
            ]);
            }
        }
    }

    if (is_array($deletedLevels)) {
    foreach ($deletedLevels as $level) {
            $db->queryFetch("CALL sp_Levels(3, ?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)",[
                $level
            ]);
        }
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
        'result' => "levels Updated Succesfully", 
    ]);
    return;
    }
    else{
        echo json_encode([
            'status' => false,
            'error' => $exception
        ]);
        return;
    }
}