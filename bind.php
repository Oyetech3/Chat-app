<?php

include_once "connection.php";

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];


    $sel = "SELECT * from datas where username = '$username' ";
    $result = $conn->query($sel);

    if($result->num_rows > 0) {
        echo "<div class='errorfile'>User already exist</div>";
        
    }
    else {
        $sql = "INSERT into datas(fullname,username,gender,numb,pword)
        VALUES('$fullname','$username','$gender','$number','$password')";

       if($conn->query($sql)) {
        echo "<div class='success'>You have successfully signed up, click Sign in</div>";
        //header("location:signin.php");
       }
       else {
         echo "Inserting error " . $conn->error;
       }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .errorfile {
               background-color: rgba(255, 68, 0, 0.544);
               width: 100%;
               height: 20px;
            }
            .success {
              width: 100%;
              height: 22px;
              background-color: rgba(178, 209, 178, 0.972);
            }
        </style>
    </head>
</html>