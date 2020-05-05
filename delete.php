<?php
include('includes/connection.php');  
 include 'functions/functions.php';
if(isset($_POST['sched_id'])){
	foreach($_POST as $var=>$value)
            $$var = mysqli_real_escape_string($con,$value);
	
	
	$delete = $con->query("DELETE FROM schedule_logs WHERE sched_id='$sched_id'");
			 
		          	
			        if($delete){
            echo "<script>alert('Successfully Deleted!'); </script> <meta http-equiv=\"refresh\" content=\"0;URL=sched_logs.php\">";
        }
			
			 
			
	
	
}

?>