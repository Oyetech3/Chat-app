<?php
session_start();
include_once "connection.php";
$user = $_SESSION["username"];

$sender = htmlspecialchars($_GET['sender']);

$sql = $conn->prepare("SELECT * FROM datas WHERE username = ?");
$sql->bind_param("s", $sender);
$sql->execute();
$result = $sql->get_result();
if($result->num_rows > 0) {


    while($row = $result->fetch_assoc()) {

        $img = "";
        $name = $row['fullname'];
        $status = $row['status'];

        if(!empty($row['picture'])) {
            $img = $row['picture'];
        }
        else {
            if($row['gender'] == "Male") {
                $img = "./images/dp.png";
            }
            else {
                $img = "./images/fdp.png";
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="message.css">
    <title>Message</title>
    <script src="https://kit.fontawesome.com/8e141485d2.js" crossorigin="anonymous"></script>

</head>
<body>
    
    <div class="allcon">

        <div class="head">
            <a href="chat.php"><i class="fa-solid fa-arrow-left-long"></i></a>
            <div class="sender">
                <img src="<?php echo $img ?>" alt="">
                <div class="details">
                    <h4><?php echo $name ?></h4>
                    <p><?php echo $status ?></p>
                </div>
            </div>
        </div>

        <div class="allcontent">
            <div class="content">
                <!--<div class="outgoing">
                    <p>Lorem ipsum dolor sit amet, sed do eiusmod tempor incididunt ut labore </p>
                </div>
                <div class="income">
                    <img src="<?//php echo $img ?>" >
                    <div class="incoming">
                        <p>Lorem ipsum dolor sit amet, sed do eiusmod tempor incididunt ut labore </p>
                    </div>
                </div>!-->
            </div>
           
            <div class="footer">
                <form class="form" autocomplete="off">
                    <input type="text" name="outgoing" value="<?php echo $user ?>" hidden>
                    <input type="text" name="incoming" value="<?php echo $sender ?>" hidden>
                    <input class="msg" name="message" placeholder="Type your message here..." type="text">
                    <button type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
    
        </div>
        
    </div>

    <script src="message.js"></script>

</body>

</html>