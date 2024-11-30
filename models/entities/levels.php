<?php

require_once __DIR__.'/../../config/db.php';

class LevelModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getAllLevels() {
        return $this->db->queryFetchAll("CALL sp_Levels(4, NULL, NULL, NULL, NULL, NULL, NULL)");
    }

    public function getLevelById($levelId) {
        return $this->db->queryFetch("CALL sp_Levels(5, ?, NULL, NULL, NULL, NULL, NULL)", [
            $levelId
        ]);
    }

    public function getLevelsWithFilters($levelId = NULL, $creationDate = NULL, $modificationDate = NULL, $levelName = NULL, $levelNumber = NULL, $levelDescription = NULL, $levelCost = NULL, $courseId = NULL, $active = NULL) {
        return $this->db->queryFetchAll("CALL sp_Levels(5, ?, ?, ?, ?, ?, ?, ?, ?, ?,NULL)", [
            $levelId,
            $creationDate,
            $modificationDate,
            $levelName,
            $levelNumber,
            $levelDescription,
            $levelCost,
            $courseId,
            $active
        ]);
    }

    public function getLevelInfo($levelName, $levelNumber) {
        return $this->db->queryFetch("CALL sp_Levels(5, NULL,NULL,NULL,?,?,NULL,NULL,NULL,NULL,NULL)",[
            $levelName,
            $levelNumber
        ]);
    }

    public function createLevel($levelName, $levelNumber, $levelDescription, $levelCost, $courseId, $Link) {
        return $this->db->queryInsert("CALL sp_Levels(1,NULL,NULL,NULL,?,?,?,?,?,NULL,?)", [
            $levelName,
            $levelNumber,
            $levelDescription,
            $levelCost,
            $courseId,
            $Link
        ]);
    }

    public function updateLevel($levelId, $creationDate, $modificationDate, $deactivationDate, $levelDescription, $levelTitle) {
        return $this->db->queryFetch("CALL sp_Levels(2, ?, ?, ?, ?, ?, ?)", [
            $levelId,
            $creationDate,
            $modificationDate,
            $deactivationDate,
            $levelDescription,
            $levelTitle
        ]);
    }

    public function deleteLevel($levelId) {
        return $this->db->queryFetch("CALL sp_Levels(3, ?, NULL, NULL, NULL, NULL, NULL)", [
            $levelId
        ]);
    }
}
?>