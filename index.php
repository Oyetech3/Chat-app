<?php

include_once "connection.php";

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];

    $hashedpassword = password_hash($password,PASSWORD_DEFAULT);
    $status = "Offline now";

    $sel = $conn->prepare("SELECT * from datas where  username = ? ");
    $sel->bind_param("s",$username);
    $sel->execute();
    $result = $sel->get_result();

    if($result->num_rows > 0) {
        echo "<div class='errorfile'>User already exist</div>";
        
    }
    else {
        $sql = $conn->prepare(query: "INSERT into datas(fullname,username,gender,numb,pword,status)
        VALUES(?,?,?,?,?,?)");
        $sql->bind_param("ssssss",$fullname,$username,$gender,$number,$hashedpassword,$status);
        //$sql->execute();

       if($sql->execute()) {
        echo "<div class='success'>You have successfully signed up, Click Sign In</div>";
        //header("location:signin.php");
       }
       else {
         echo "Inserting error " . $conn->error;
       }
    }
}

//$conn->close();


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <script src="https://kit.fontawesome.com/8e141485d2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="signup.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!--<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">!-->
        
    </head>
    <body>
        <div class="allcontainer">
            <div class="head">
                <h2>SIGN UP PAGE</h2>
            </div>
            <div class="form">
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data" autocomplete="off">
                    <label>Fullname</label><br>
                    <input type="text" name="fullname" placeholder="Enter your fullname">
                    <br><br>

                    <label>Username</label><br>
                    <input type="text" name="username" placeholder="username">
                    <br><br>

                    <label>Gender</label><br>
                    <input type="radio" name="gender" value="Male"><span>Male</span>
                    <input type="radio" name="gender" value="Female"><span>Female</span>
                    <br><br>

                    <label>Number</label><br>
                    <input type="number" name="number" placeholder="08000000000">
                    <br><br>

                    <label>Password</label><br>
                    <div class="pass">
                        <input type="password" name="password">
                        <i id="noshow" class="fa-solid fa-eye-slash"></i>
                        <i id="eye" class="fa-solid fa-eye"></i>
                    </div>
                    <br>

                    <div class="but">
                        <button type="submit">Sign Up</button>
                    </div>
                </form>
                <p>Already have have account ? <span class="span"><a href="signin.php">Sign in</a></span></p>
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
