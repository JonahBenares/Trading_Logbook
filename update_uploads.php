<?php 
include 'includes/connection.php';
foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	
	 if(isset($_GET['id'])){
            $id = $_GET['id'];
    		$view=$_GET['view'];
        } else {
            $id = '';
        }

        $max=$id;

	
	   
																
										
						  for($a=1;$a<=$counter;$a++){
							$sql2 = mysqli_query($con,"SELECT MAX(upload_id) as logid FROM upload_logs");
								$row2 = mysqli_fetch_array($sql2);
								$ymx = $row2['logid'];
									
						  	 $file="attach_file".$a;
								if(!empty($_FILES[$file]["name"])){

						  	 $activity = $_FILES[$file]['tmp_name'];
               				 $act = $_FILES[$file]["name"];
               				 $file = explode(".", $act); //attach file
					         $ext = $file[1]; //extension
					         $afile = $max."_".$a.$ymx.".".$ext;
							 move_uploaded_file($_FILES['attach_file'.$a]['tmp_name'], "images/" . $afile);
						  	 if(mysqli_query($con,"INSERT INTO upload_logs (log_id, file_name)  VALUES ('$max', '$afile')")){
						  	 	$error=0;
						  	 } else {
								$error=1;
							}	
						  $ymx++;
						  }

						}

						  if($error==0){
						  	echo "Success";
						  }
															 
						  
?>