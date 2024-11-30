<?php

require __DIR__.'/../../config/db.php';

class ContentsModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getContentsOfLevel($levelId) {
        return $this->db->queryFetchAll("CALL sp_Contents(4, NULL,NULL,NULL, NULL, ?)", [
            $levelId
        ]);
    }

    public function insertContent($file, $fileName, $type, $levelInfo) {
        return $this->db->queryInsert("CALL sp_Contents(1,NULL,?,?,?,?)",[
            $file,
            $fileName,
            $type,
            $levelInfo
        ]);
    }
}
?>