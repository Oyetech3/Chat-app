<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "registration";



$conn = new mysqli($hostname,$username,$password,$database);

if($conn->connect_error) {
    die("Error connecting" . $conn->connect_error);
}






