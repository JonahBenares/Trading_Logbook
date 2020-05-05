<?php 
include 'includes/connection.php';
date_default_timezone_set("Asia/Taipei");
session_start();
$user = $_SESSION['userid'];

$day = date('Y-m-d');
$hour = date('H');


$get_exist=$con->query("SELECT log_id FROM activity_log WHERE user_id ='$user' AND logged_date = '$day' AND logged_time LIKE '$hour%'");
$row_exist = $get_exist->num_rows;
echo $row_exist;

?>