<?php 
include 'includes/connection.php';
date_default_timezone_set("Asia/Taipei");
session_start();
if(isset($_POST['login'])){
    foreach($_POST as $var=>$value)
        $$var = mysqli_real_escape_string($con, $value);
    $ss = md5($password);
    $get=$con->query("SELECT * FROM users WHERE status = 'Active' AND username = '$username' AND (password='$password' OR password = '$ss')");
    $rows = $get->num_rows;
    $fetch=$get->fetch_array();
    if($rows>0){
        $_SESSION['userid'] = $fetch['user_id'];
        $_SESSION['username'] = $fetch['username'];
        $_SESSION['fullname'] = $fetch['fullname'];
        if($fetch['usertype_id'] == 1) $_SESSION['usertype'] = 'Admin';
        if($fetch['usertype_id'] == 2) $_SESSION['usertype'] = 'Staff';
        $date = date("Y-m-d");
        $time = date("H:i:s");
        mysqli_query($con,"INSERT INTO login_logs (user_id, login_date, login_time) VALUES ('$fetch[user_id]', '$date', '$time')");
        echo "<script>window.location = 'dashboard.php';</script>";
    } 

    else {
        echo "<script>alert('Username/Password incorrect Or Inactive'); window.location = 'index.php';</script>";
    }
}
?>