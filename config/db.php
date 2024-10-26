<?php

class Database{
    public $connection;

    public function __construct($config){
        $dsn = 'mysql:' . http_build_query($config,"",";");

        $this->connection = new PDO($dsn, $config['user'], $config['password']);
    }

    public function querySelect($query, $array = []){
        $stmt = $this->connection->prepare($query);

        $stmt->execute($array);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function queryInsert($query, $array = []){
        $stmt = $this->connection->prepare($query);

        $stmt->execute($array);

    }
}
