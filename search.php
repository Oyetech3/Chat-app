<?php
session_start();
include_once "connection.php";

$user = $_SESSION['username'];

$searchValue = htmlspecialchars($_POST["searchValue"]);

$sql = "SELECT * from datas WHERE fullname LIKE '%$searchValue%' and NOT username = '$user'";
$result = $conn->query($sql);


$contents = "";

if($result->num_rows > 0) {
    include_once "getusers.php";
    
}
else {
    $contents .= "User not found";
}
echo $contents;