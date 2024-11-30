<?php

require_once __DIR__.'/../../config/db.php';

class MessagesModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getChats($from, $to) {
        return $this->db->queryFetchAll("CALL sp_Chats(1, ?, ?)", [
            $from,
            $to
        ]);
    }

    public function getMessagesFromTo($from, $to) {
        return $this->db->queryFetchAll("CALL sp_Messages(2, NULL, ?, ?, NULL)", [
            $from,
            $to
        ]);
    }

    public function sendMessage($from, $to, $message) {
        return $this->db->queryInsert("CALL sp_Messages(1, NULL, ?, ?, ?)", [
            $from,
            $to,
            $message
        ]);
    }
}
?>