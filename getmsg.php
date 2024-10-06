<?php
session_start();
$user = $_SESSION['username'];
include_once "connection.php";

$outgoing = htmlspecialchars($_POST['outgoing']);
$incoming = htmlspecialchars(($_POST['incoming']));
$content = "";

$sql2 = $conn->prepare("SELECT * FROM datas WHERE username = ?");
$sql2->bind_param("s", $incoming);
$sql2->execute();
$result2 = $sql2->get_result();
if($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        $img = "";
        $name = $row['fullname'];
        if(!empty($row['picture'])) {
            $img = $row['picture'];
        }
        else {
            if($row['gender'] == "Male") {
                $img = "dp.png";
            }
            else {
                $img = "fdp.png";
            }
        }
    }
}

$sql = $conn->prepare("SELECT * FROM messages WHERE (outgoing = ? AND incoming = ?) OR (outgoing = ? AND incoming = ?) ORDER BY msgid ");
$sql->bind_param("ssss",$outgoing,$incoming,$incoming,$outgoing);
$sql->execute();
$result = $sql->get_result();

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($row['outgoing'] === $outgoing) {
            $content .= '
                <div class="outgoing">
                    <p>'. $row['msg'] .'</p>
                </div>
            ';
        }
        else {
            $content .= '
                <div class="income">
                    <img src="'. $img .'" >
                    <div class="incoming">
                        <p>'.$row['msg'].'</p>
                    </div>
                </div>
            ';
        }
    }
}
echo $content;