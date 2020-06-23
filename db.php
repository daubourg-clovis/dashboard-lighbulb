<?php

$servername = 'localhost';
$user ='root';
$password = '';
$db = 'immeuble';

try{
    $pdo = new PDO("mysql:host=$servername;port=3308;dbname=$db", $user, $password);
} catch(PDOExeption $e){
    echo 'Connection failed' . $e->getMessage();
}