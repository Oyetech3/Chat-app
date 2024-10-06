<?php
session_start();
include_once "connection.php";

$user = $_SESSION['username']; 



$sql = $conn->prepare("SELECT * FROM datas WHERE NOT username = ?");
$sql->bind_param("s",$user);
$sql->execute();
$result = $sql->get_result();
$contents = "";

if($result->num_rows == 1) {
    $contents .= "No user found";
}
elseif($result->num_rows > 0 ) {
    include_once "getusers.php";
}
echo $contents;