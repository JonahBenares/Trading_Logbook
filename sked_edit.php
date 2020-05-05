<?php 
include 'includes/connection.php';
foreach($_POST as $var=>$value)
	$$var = mysqli_real_escape_string($con, $value);
	
	date_default_timezone_set("Asia/Manila");
    $current =  date("Y-m-d").' '. date("H:i:s");
	    $day1=date_create($start_date);
        $day2=date_create($end_date);
            $diff = $day1->diff($day2);
            $days = $diff->format("%a");

        if(isset($chk_nshft)){
        	$nshift=1;
        } else {
        	$nshift=0;
        }
		
		if(empty($chk_nshft)){
			
			$chk_nshft='0';
			
		}
                         $x='';
						 $xxy=new DateTime($start_date);
						while($x <= $days){ 
	                      if($x==0){
	                      mysqli_query($con,"INSERT INTO schedule_logs (user_id, sched_date, date_plotted, start_hr, end_hr, remarks, night_shift) 
	                                   VALUES ('$userid', '$start_date', '$current', '$start_time', '$end_time', '$remarks', '$chk_nshft')");
							}else{
								
								 mysqli_query($con,"INSERT INTO schedule_logs (user_id, sched_date, date_plotted, start_hr, end_hr, remarks, night_shift) 
	                                   VALUES ('$userid', '$xxyy', '$current', '$start_time', '$end_time', '$remarks', '$chk_nshft')");
							}
						              $xxyy = $xxy ->modify('+1 day')->format('Y-m-d');
						              $x++;  
						      }
						    echo "Success";
?>