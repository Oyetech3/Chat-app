<?php
session_start();
$user = $_SESSION['username'];
include_once "connection.php";

$outgoing = htmlspecialchars($_POST['outgoing']);
$incoming = htmlspecialchars(($_POST['incoming']));
$message = htmlspecialchars($_POST['message']);

$sql = $conn->prepare("INSERT INTO messages(outgoing,incoming,msg)
VALUES(?,?,?)");
$sql->bind_param("sss",$outgoing,$incoming,$message);
$sql->execute();
$sql->get_result();


//echo $message;
