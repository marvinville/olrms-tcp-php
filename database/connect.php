<?php

$env = 0;

$username = "marvinv";
$password = "marvinv";

if ($env === 1) {
    $username = "root";
    $password = "@Olrms-service1";
}

$serverName = "localhost";
$db = "olrms_service";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
