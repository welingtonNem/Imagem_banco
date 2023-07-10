<?php

$host = "localhost";
$user = "root";
$pass = "";
$bd = "upload";

$conn = new mysqli($host, $user, $pass, $bd);

if ($conn->connect_errno) {
    echo "Connect failed" . $conn->connect_error;
    exit();
}


?>