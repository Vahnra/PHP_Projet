<?php session_start();

$host = 'mysql:host=localhost;dbname=deal'; 
$login = 'root'; 
$password = ''; 
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
);

$pdo = new PDO($host, $login, $password, $options);

?>