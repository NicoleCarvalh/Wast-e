<?php

    session_start();

    $host = 'localhost';
    $dbname = 'wast-e';
    $user = 'root';
    $password = '';

    try {
        $connection = new PDO(
            "mysql:host=$host;dbname=$dbname",
            "$user",
            "$password"
        );
    } catch(PDOException $e) {
        echo "<p>$e->getMessage()</p>";
    }
    
?>