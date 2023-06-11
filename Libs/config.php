<?php

define("DS", DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__) . DS);
define('ROOT_VIEWS', dirname(__DIR__) . DS . 'Views' . DS);

// INFOMATION DE CONNEXION À LA BASE DE DONNÉES
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '7288Ndeko*');
define('DB_NAME', 'learn-php');
define('DNS', "mysql:host=" . DB_HOST . ';dbname=' . DB_NAME . '');
define('DB_OPTIONS', [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
