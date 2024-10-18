<?php
session_start();
include_once "connection.php";

if(!isset($_SESSION['username'])) {
    header("location:signin.php");
    exit();
}
else {
    
    $user = $_SESSION['username']; 

    $sel = $conn->prepare("SELECT * from datas where username = ? ") ;
    $sel->bind_param("s", $user);
    $sel->execute();
    $result = $sel->get_result();

    $fullname = $gender = $number = "";

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $fullname = $row['fullname'];
            $gender = $row['gender'];
            $number = $row['numb'];
        }
    }

    $sel->close();

    if(isset($_POST['logout'])) {
        $status = "Offline now";
        $sql = "UPDATE datas SET status = '$status' WHERE username = '$user'";
        if($conn->query($sql)) {
            session_unset();
            session_destroy();
            header("location:signin.php");
            exit();
        }

    }

    $change = 0;

    if($gender == "Male") {
        $none = "./images/dp.png"; 
    }
    else {
        $none = "./images/fdp.png";
    }

    $stmt = $conn->prepare("SELECT picture FROM datas WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $res = $stmt->get_result();

    if (!$res) {
        die("Query failed: " . $conn->error);
    } 
    $chk = $res->num_rows > 0;

    if($chk) {
        $row = $res->fetch_assoc();
        $change = 1;
        if(!empty($row['picture'])) {
            $img = $row['picture'];
        }
        else {
            $change = 0;
        }
    
    }


    $stmt->close();




    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])) {
        $image = $_FILES["picture"];

        
        $dir = "uploads/";
        $file = $dir . basename($image["name"]);
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $uploadOk = 1;
        $extensions = array("jpeg","jpg","png");

        if(isset($_POST['submit'])) {
            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if($check == false) {
                echo "<div class='errorfile'>Error, file is not an image</div>";
                $uploadOk = 0;
            }
        }

        
        
        if($uploadOk == 1 && in_array($type,$extensions)) {
                move_uploaded_file($image["tmp_name"], $file);
                $upload = $conn->prepare("UPDATE datas SET picture = ? where username = ? ");
                $upload->bind_param("ss",$file,$user);

                if($upload->execute()) {
                    echo "<div class='success'>Your picture has been uploaded successfully</div>";
                    $img = $file;
                    $change = 1;
                    $upload->close();
                }
                else {
                    echo "<div class='errorfile'>Sorry, your picture was not uploaded</div>";
                }

            
            }
        else {
            echo "<div class='errorfile'>Sorry, Invalid file type</div>";
            }
        
        
    }

}

?>

<!DOCTYPE html>
<html>
    <body>
        <head>
            <link rel="stylesheet" href="homepage.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Homepage</title>
            
        </head>
        <div class="allcon">
            <div class="profile">
                <h1><span>Your</span> Profile</h1>
                <img class="dp" alt="Picture" src="<?php echo !$change ? $none : $img ?>">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
                    <input type="file" name="picture">
                    <input type="submit" value="Upload Picture" name="submit">
                </form>
            </div>
            <a  href="chat.php">
                <div class="chats">
                    <p>Go To Chat</p>
                    <i class="fa-brands fa-rocketchat"></i>
                </div>
            </a>
            
            <div class="details">
                <h2><span>Fullname : </span><?php echo htmlspecialchars($fullname)?> </h2>
                <h2><span>Username : </span><?php echo htmlspecialchars($username)?> </h2>
                <h2><span>Gender : </span><?php echo htmlspecialchars($gender) ?> </h2>
                <h2><span>Phone Number : </span><?php echo htmlspecialchars($number) ?> </h2>
            </div>
            <form method="post">
                <button type="action" name="logout">Log Out</button>
            </form>
        </div>
    </body>
</html>