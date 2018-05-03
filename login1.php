<?php
session_start();
$conn = mysqli_connect("localhost","root","","rating_system");
    
$message="";
if(!empty($_POST["login"])) {
    $result = mysqli_query($conn,"SELECT * FROM tbl_users WHERE user_name='" . $_POST["user_name"] . "' and password = '". $_POST["password"]."'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)) {
    $_SESSION["user_id"] = $row['user_id'];
    $_SESSION["user_name"] = $row['user_name'];

    } else {
    $message = "Invalid Username or Password!";
    }
}
header('Location: /rsd/index.php'); 
?>