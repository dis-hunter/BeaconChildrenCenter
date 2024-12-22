<?php

$host='beacons-db-1.cha0wq86s9jm.eu-north-1.rds.amazonaws.com';
$dbname="db_beacons";
$username='postgres';
$password='passw0rd';
$port='5432';
$pdo=new PDO("pgsql:host=$host;port=$port;dbname=$dbname",$username,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
if($pdo){
    echo "Connected Succesfully";
}else{
    echo "Failed";
}