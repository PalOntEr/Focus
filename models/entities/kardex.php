<?php

require_once __DIR__.'/../../config/db.php';

class KardexModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getAllKardex() {
        return $this->db->queryFetchAll("CALL sp_Kardex(4, NULL, NULL, NULL, NULL, NULL, NULL)");
    }

    public function getKardexById($levelId) {
        return $this->db->queryFetch("CALL sp_Kardex(5, ?, NULL, NULL, NULL, NULL, NULL)", [
            $levelId
        ]);
    }

    public function getKardexWithFilters($startDate = NULL, $accessDate = NULL, $completionDate = NULL, $userId = NULL, $courseId = NULL, $category = NULL) {
        return $this->db->queryFetchAll("CALL sp_Kardex(6, ?, ?, ?, ?, ?, ?)", [
            $startDate,
            $accessDate,
            $completionDate,
            $userId,
            $courseId,
            $category
        ]);
    }
}
?>