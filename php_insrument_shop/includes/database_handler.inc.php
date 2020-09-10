<?php

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "magazin2";

    try {
        $conn = new PDO("mysql:host=$servername; dbname=$dbName", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
    } 

?>