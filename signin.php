<?php

include_once "connection.php";

if($_SERVER['REQUEST_METHOD'] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $sel = $conn->prepare("SELECT * from datas where username = ?  ");
    $sel->bind_param("s",$username);
    $sel->execute();
    $result = $sel->get_result();

    

    if(empty($username) || empty($password)) {
        echo "<div class='errorfile'>Kindly input your username and password</div>";
    }
    else {
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedpassword = $row['pword'];
            $user = $row['username'];

            if(password_verify($password,$hashedpassword)) {
                session_start();

                $status = "Active now";
                $sql = "UPDATE datas SET status = '$status' WHERE username = '$user'";
                if($conn->query($sql)) {
                    $_SESSION['username'] = $user;
                }
    
                //echo "<div class='success'>You have logged in successfully</div>";
                header("location:homepage.php");
                exit();
            }
            else {
                echo "<div class='errorfile'>Incorrect password</div>";
            }

        }
        else {
            echo "<div class='errorfile'>You do not have an account yet, Kindly Sign up</div>";
        }
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="signin.css">
    <script src="https://kit.fontawesome.com/8e141485d2.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<div class="allcontainer">
            <div class="head">
                <h2>SIGN IN PAGE</h2>
            </div>
            <div class="form">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" autocomplete="off">

                    <label>Username</label><br>
                    <input type="text" name="username" placeholder="username">
                    <br><br>


                    <label>Password</label><br>
                    <div class="pass">
                        <input type="password" name="password">
                        <i id="noshow" class="fa-solid fa-eye-slash"></i>
                        <i id="eye" class="fa-solid fa-eye"></i>
                    </div>
                    <br>

                    <div class="but">
                        <button type="submit">Sign In</button>
                    </div>
                </form>
                <p>Don't have an account ? <span class="span"><a href="signup.php">Sign up</a></span></p>
            </div>
        </div>

        <script>
            
            const eyeShow =document.getElementById("eye")
            const noShow =document.getElementById("noshow")
            const password =document.querySelector(".pass input")
            const pass =document.querySelector(".pass")

            
            eyeShow.onclick = () => {
                eyeShow.style.display = "none"
                noShow.style.display = "inline"

                pass.classList.toggle("active");
                if(pass.classList.contains("active")) {
                    password.type = "text";
                }
                else {
                    password.type = "password"
                }
            
            }
            noShow.onclick = () => {
                noShow.style.display = "none"
                eyeShow.style.display = "inline"

                pass.classList.toggle("active");
                if(pass.classList.contains("active")) {
                    password.type = "text";
                }
                else {
                    password.type = "password"
                }
            
            }
            

        </script>
</body>
</html>