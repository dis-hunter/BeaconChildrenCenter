<?php

$host='beacons-db-1.cha0wq86s9jm.eu-north-1.rds.amazonaws.com';
$dbname="db_beacons";
$username='postgres';
$password='passw0rd';
$port='5432';
$pdo=new PDO("pgsql:host=$host;port=$port;dbname=$dbname",$username,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
if($pdo){
    print_r($pdo);
    echo "Connected Succesfully";
    echo "<br>PDO Connection Details:<br>";
    echo "DSN: " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "<br>";
    echo "Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "<br>";
    echo "Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
    echo "Client Version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
    
}else{
    echo "Failed";
}
$pdo=null; //close connection