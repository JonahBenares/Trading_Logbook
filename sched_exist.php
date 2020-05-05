<?php
include 'includes/connection.php';
foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);

	$check = mysqli_query($con, "SELECT sched_id FROM schedule_logs WHERE user_id = '$id' AND sched_date='$startdate'");
	
	$rows = $check->num_rows;
	if($rows!=0){
		echo "error";
	} else {
		echo "ok";
	}