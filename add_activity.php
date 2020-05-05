<?php 
error_reporting(0);

include 'includes/connection.php';

foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	
	$sql1 = mysqli_query($con,"SELECT MAX(log_id) as logid FROM activity_log");
	$row1 = mysqli_fetch_array($sql1);
	$max = $row1['logid'] + 1;

	date_default_timezone_set("Asia/Manila");
    $current =  date("Y-m-d").' '. date("H:i:s");

                       
  	$insert  = mysqli_query($con,"INSERT INTO activity_log (log_id, user_id, encoded_date, logged_date, logged_time, notes) VALUES ('$max', '$userid', '$current', '$logdate', '$loghour', '$notes')");
	if($insert){
		$error=0;
	} else {
		$error=1;
	}				

				
  	for($a=1;$a<=$counter;$a++){
  	$file="attach_file".$a;
	if(!empty($_FILES[$file]["name"])){
  	$activity = $_FILES[$file]['tmp_name'];
		$act = $_FILES[$file]["name"];
		$file = explode(".", $act); //attach file
    $ext = $file[1]; //extension
    $afile = $max."_".$a.".".$ext;
	move_uploaded_file($_FILES['attach_file'.$a]['tmp_name'], "images/" . $afile);
  	if(mysqli_query($con,"INSERT INTO upload_logs (log_id, file_name)  VALUES ('$max', '$afile')")){
  	 	$error=0;
  	} else {
		$error=1;
	}	
  
  	}

  	if($error==0){
		
  	echo "Success";
	
  	}
	}												 
						  
?>