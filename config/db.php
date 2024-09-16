<?php
// Configuración de la base de datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'DB_Cursos');

function getDatabaseConnection() {
    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($connection->connect_error) {
        die("Conexión fallida: " . $connection->connect_error);
    }
    return $connection;
}

// Configuración de error
error_reporting(E_ALL);
ini_set('display_errors', 1);
