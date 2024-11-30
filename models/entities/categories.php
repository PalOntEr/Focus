<?php

require_once __DIR__.'/../../config/db.php';

class CategoriesModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getCategories() {
        return $this->db->queryFetchAll("CALL sp_Categories(6,NULL,NULL,NULL,NULL)");
    }

    public function insertCategory($name, $desc, $creatorId) {
        return $this->db->queryFetch("CALL sp_Categories (1,NULL, ?, ?,?)", [
            $name,
            $desc,
            $creatorId
        ]);
    }

    public function deleteCategory($categoryId) {
        return $this->db->queryFetch("CALL sp_Categories (3, ?, NULL, NULL, NULL)", [
            $categoryId
        ]);
    }
}
?>