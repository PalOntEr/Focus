<?php

require_once __DIR__.'/../../config/db.php';

class CommentsModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getCommentsWithFilters($commentId = NULL, $creationDate = NULL, $deactivationDate = NULL, $comment = NULL, $userId = NULL, $courseId = NULL, $rating = NULL) {
        return $this->db->queryFetchAll("CALL sp_Comments(5, ?, ?, ?, ?, ?, ?, ?)", [
            $commentId,
            $creationDate,
            $deactivationDate,
            $comment,
            $userId,
            $courseId,
            $rating
        ]);
    }

    public function insertComment($comment, $userId, $courseId, $rating) {
        return $this->db->queryInsert("CALL sp_Comments(1,NULL,NULL,NULL,?,?,?,?)",[
            $comment,
            $userId,
            $courseId,
            $rating
        ]);
    }

    public function removeComment($commentId, $deletionReason, $userId) {
        return $this->db->queryFetch("CALL sp_Comments(3,?,NULL,NULL,?,?,NULL,NULL)",[
            $commentId,
            $deletionReason,
            $userId
        ]);
    }

    public function getDeletedComments() {
        return $this->db->queryFetchAll("CALL sp_Comments(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL)");
    }
}
?>