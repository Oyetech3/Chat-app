<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chat.css">
    <script src="https://kit.fontawesome.com/8e141485d2.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="allcon">
        <div class="head">
            <a href="homepage.php"><i class="fa-solid fa-arrow-left-long"></i></a>
            <p>Chats</p>
            <div class="hd">
                <input id="srch" type="search" placeholder="Search" autocomplete="off">
                <div class="icon" >
                    <!--<i id="fr" class="fa-solid fa-magnifying-glass"></i> !-->
                    <i id="sc" class="fa-solid fa-xmark"></i>
                    
                </div>
                
            </div>
        </div>

        <div class="chats">

<!--
            <div class="all">
                <div class="image">
                    <img src="images/nuru.jpg" alt="">
                </div>
                <div class="mess">
                    <div class="txts">
                        <h3>Nasrudeen Nurudeen</h3>
                        <p>This is a message</p>
                    </div>
                    <div class="cir"></div>
                </div>
            </div>
!-->
        </div>
    </div>

    <script src="chat.js"></script>
</body>
</html>