<?php

$servername = "localhost";
$username = "root";
$password = "Iml@b1";
$dbname = "imlab";

// Connects to Our Database
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>