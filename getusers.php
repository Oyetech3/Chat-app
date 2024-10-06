<?php
$user = $_SESSION['username'];
include_once "connection.php";

while($row = $result->fetch_assoc()) {

    $lastmsg = "";
    $from = "";
    $sql2 = $conn->prepare("SELECT * FROM messages WHERE (incoming = ? OR outgoing = ?) AND (outgoing = ? OR  incoming = ?) ORDER BY msgid DESC LIMIT 1");
    $sql2->bind_param("ssss",$row['username'],$row['username'],$user,$user);
    $sql2->execute();
    $result2 = $sql2->get_result();
    $row2 = $result2->fetch_assoc();

    if($result2->num_rows > 0) {
        $lastmsg = $row2['msg'];
    }
    else {
        $lastmsg = "No message available";
    }
    (strlen($lastmsg) > 30) ? $lmsg = substr($lastmsg,0,30). "..." : $lmsg = $lastmsg;
    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
    
    if($row2) { 
        ($row2['outgoing'] == $user) ? $from = "You: " : $from = "" ;
    }

    

    $img = "";
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
    $contents .= '
     <a href="message.php?sender='. $row['username']. '">
        <div href="" class="all">
            <div class="image">
                <img src="'. $img .'" alt="">
            </div>
            <div class="mess">
                <div class="txts">
                    <h3>'. $row['fullname'] .'</h3>
                    <p>'. $from . $lmsg .'</p>
                </div>
                <div class="cir '.$offline.' "></div>
            </div>
        </div>
    </a>
    ';
}