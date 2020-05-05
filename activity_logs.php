<?php 
    include 'header.php';
	$userid=$_SESSION['userid'];
	 $user_name = $_SESSION['fullname'];
	 if(isset($_POST['updateActivity'])){
       updateActivity($con,$_POST);
	   }
?>
<script src="assets/js/jquery-1.12.4.js"></script>
<script type="text/javascript">

    function updateActivity(log_id, view){
      window.open('update_activity.php?id='+log_id+'&view='+view, '_blank', 'width=600,height=640');
    }
	
	$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $("#input_fields_wrap"); 
    var add_button      = $("#add_field_button"); 
    
    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ //max input box 
            x++; 
            $(wrapper).append('<div class="row"><input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file'+x+'" name="myfile[]"><a href="#" style="width:10%" class="remove_field"><i class="material-icons">clear</i></a></div>'); //add input box
            var uploadField = document.getElementById("file"+x);
			uploadField.onchange = function() {
			    if(this.files[0].size > 2000000){
			       alert("File is too big! Maximum of 2MB per file");
			       this.value = "";
			    };
			}
        }
       document.getElementById('counter').value = x;
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

function addActivity(){
   // var data = $("#add-activity").serialize();
   var input, file;
   counter = document.getElementById('counter').value;

   if(counter===''){
     var ctr = 1;
   } else {
     var ctr = counter;
   }
   
   var frm = new FormData();

   frm.append('counter', ctr);

   if(ctr==1){
       act = document.getElementById('file1');
       frm.append('attach_file1', act.files[0]);

    } 
    else if(ctr>=2){
        for(x=1;x<=ctr;x++){
           act = document.getElementById('file'+x);
           frm.append('attach_file'+x, act.files[0]);
		   
		   			
        }
    } 

    var userid =document.getElementById('userid').value;
    var logdate =document.getElementById('log_date').value;
    var loghour =document.getElementById('log_hour').value;
    var notes =document.getElementById('notes').value;
   
    frm.append('userid', userid);
    frm.append('logdate', logdate);
    frm.append('loghour', loghour);
    frm.append('notes', notes);

   
   $.ajax({
        data: frm,
        type: "post",
        url: "add_activity.php",
        contentType: false,
        processData: false,
        cache: false,
        success: function(output){
        
            var output = output.trim();
			  
			
            if(output == "Success"){
               
			   window.alert('Activity successfully added!');
			   
			   
                window.location = 'activity_logs.php';
            }
        
        }
		
    });
}

</script>
<body>
    <div class="wrapper">
        <?php include('sidebar.php');?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php include('navbar.php'); ?>			
			<!-- Add Activity Logs -->
			<div class="modal fade" id="btn_addActivity" tabindex="-1" role="dialog" aria-labelledby="addActivity_modal" aria-hidden="true" >
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header modal-color" >
			                <h5 class="modal-title" id="addActivity_modal">
			                    <strong>ADD ACTIVITY</strong>
			                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="color:#fff">
			                    <span aria-hidden="true">&times;</span>
			                </button>
			                </h5>                
			            </div>
						<hr class="hr_nomarg">           
						<?php 
							date_default_timezone_set("Asia/Manila");
							
			                $current_date =  date("Y-m-d");
							$current_time = date("H:i");
							
							// initial query
							$check_duty = mysqli_query($con,"SELECT * FROM schedule_logs where user_id = '$userid' AND sched_date = '$current_date'");
							$row2 = mysqli_fetch_array($check_duty);
							$sched_d=$row2['sched_date'];
							$start_t=$row2['start_hr'];
							$end_t=$row2['end_hr'];
							$night_shift=$row2['night_shift'];
							 
							$current_date2 =  date("Y-m-d".$current_time);
							$current_date2s =strtotime($current_date2);
							$current_time2 =  strtotime($current_time);
			                $end_t2 = strtotime($end_t);
							$start_t2 = strtotime($start_t);   
							
							$end_t2_d = date($end_t);
							$start_t2_d = date($start_t);   
							
							//+1 day
							$sched_d_minus1 = new DateTime($sched_d);
			                $sched_d1 = $sched_d_minus1 ->modify('+1 day')->format('Y-m-d');

					        //duration of duty time
					        $duration_a = new DateTime($start_t);
			                $duration_b = new DateTime($end_t);
			                $duration_interval = $duration_b->diff($duration_a);
							$duration_intervals = $duration_interval->format("%h");
						?>
						
						<?php
							switch ($current_date) {
							case ($current_date!=$sched_d):
						?> 
						<div class="modal-body" style="height:200px">
							<div class="contianer">	
								<div class="alert alert-danger">
									<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
									<div class="form-group label-floating "> 					
										<div id="errorBox">
											<?php
												echo $sched_d;
											?> Your not On-Duty, Please Contact System Administrator
										</div>
									</div>						
								</div>	
							</div>
						</div>
						<?php
							break;
							//Regular Duty 
							case($current_date==$sched_d && $night_shift!=1 ):
							if($current_time2 < $start_t2){
								echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i></span><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
												<div id='errorBox'>";		  
												$aaa = new DateTime($start_t);
											 	$bbb = new DateTime($current_time);
											 	$interval_ess = $bbb->diff($aaa);
												echo "Sorry, you are unable to add activity! You still have ".$interval_ess->format("%H hour/s and %i")."min/s before your Duty";
												echo "</div></div></div></div></div>";
											
							}else if($current_time2 > $end_t2){											   
								echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
												<div id='errorBox'>";
													$a_a = new DateTime($end_t);
									 				$b_b = new DateTime($current_time);
									 				$interval_ab = $a_a->diff($b_b);
												   	echo "Sorry, you are unable to add activity! You already exceed/s ".$interval_ab->format("%H hour/s and %i")." min/s on your Duty Time out,";
												   	echo " Or the admin Plotted a wrong schedule.!!";
												   	echo "</div></div></div></div></div>";
							}else{
						?>
					    <?php
					    	// check number of logs
				            $activity_count = mysqli_query($con,"SELECT * FROM activity_log where user_id = '$userid' AND logged_date = '$current_date'");
							//$activity_count_row = mysqli_fetch_array($activity_count);
							$rowCount = mysqli_num_rows($activity_count );
	                        $duration_time = $duration_intervals;
	                        //+1 hour
					     	$start_time = new DateTime($start_t);
					     	//round up time next hour
							$datetime = DateTime::createFromFormat('H:??', $current_time);
							$current_times=$datetime->modify('next hour')->format('H:i');
							$current_times;
                            //$current_time = date("H:i")

                            //check Max activity log
							$sql_check_log = mysqli_query($con,"SELECT MAX(logged_time) as logged_time FROM activity_log where user_id='$userid' and logged_date='$current_date' ");
							$row1_sql_check_log = mysqli_fetch_array($sql_check_log);
							$max_logged = $row1_sql_check_log['logged_time']; 
							$max_logged2 = strtotime($max_logged);   
							 
							                  $max_lod2 = new DateTime($max_logged);
						                     $max_tm = $max_lod2->modify('next hour')->format('H:00');
											  //$max_tm = $max_tm->format('H:i');
                                             $start_t69= strtotime($max_tm);
							 
							 
							for($l=0;$l<$duration_time;$l++){
							   
							$duration_time;
					        $start_time->modify('+1 hour');
					       $st = $start_time->format('H:i');
					       	$start_t6 = strtotime($st);  
							                  
							                 

					       	switch($duration_time){
							case($rowCount==0):
						?>
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">				
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating ">
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating "> 
							 			<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
											
										
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 
						</div>														
						<?php
							$l=$duration_time; //endo
							break;
							case($rowCount==$duration_time):
							
								echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
											<div id='errorBox'>";
											echo "Sorry, you are unable to add activity, ALready reached the maximum activity logs !";
											echo "</div></div></div></div></div>";
						   
						   	$l=$duration_time; //endo
                    	 	break;	
							
							case($max_tm>=$current_time):
							
							      echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
											<div id='errorBox'>";
											echo "Sorry need to wait next hour!";
											echo "</div></div></div></div></div>";
								
						   	$l=$duration_time; //endo
                    	 	break;	
							
                    	 	case($max_tm<$current_time):
							
						?>	
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating "> 
										<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
									</div>
								</div>				
								<div class="col-md-12">
									<div class="form-group ">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"><?php //echo $max_tm; ?></textarea>
										</div>
									</div>
								</div> 															
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' nam	e='counter' id='counter'>
							</form>
						</div>
						<?php
							
							$l=$duration_time; //endo
							break;
							default:
							 
							}
							
							}
						?>
						<?php
							}//Night Shift
							break;
							case ($current_date==$sched_d && $night_shift==1 ):							   
							// second query
							$check_duty2_1 = mysqli_query($con,"SELECT * FROM schedule_logs where user_id = '$userid' AND sched_date = '$sched_d1'");
							$row2_1 = mysqli_fetch_array($check_duty2_1);
							$sched_d_ntt=$row2_1['sched_date'];
							$sched_d_ntt2 = strtotime($sched_d_ntt);
							$end_t_nt=$row2_1['end_hr'];
							$end_t_nt2 = strtotime($end_t_nt);
							$time_nextday = strtotime($sched_d_ntt.' '.$end_t_nt);

							$pms='18:00';
							$pm=strtotime($pms);
							$ams='07:00';
							$am=strtotime($ams);
							switch($current_time2){	 
					case($current_time2<=$am):			
							if($current_time2 > $end_t2){											   
								echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
												<div id='errorBox'>";
												$a_a = new DateTime($end_t);
												$b_b = new DateTime($current_time);
												$interval_ab = $a_a->diff($b_b);
												echo "Sorry, you are unable to add activity! You already exceed/s ".$interval_ab->format("%H hour/s and %i")."min/s on your Duty Time outs";
												echo " Or  admin Plotted a wrong schedule.!!";
												echo "</div></div></div></div></div>";
			   				}else{
		   				?>
		   				<?php
							// check number of logs
				            $activity_count = mysqli_query($con,"SELECT * FROM activity_log where user_id = '$userid' AND logged_date = '$current_date'");
							//$activity_count_row = mysqli_fetch_array($activity_count);
							$rowCount = mysqli_num_rows($activity_count );
                          
							//+1 hour
							$start_time = new DateTime("00:00");
							$stt = $start_time->format('H:i');
					 
							//duration of duty time
							$duration_a_night = new DateTime($stt);
							$duration_b_night = new DateTime($end_t);
							$duration_interval_night = $duration_b_night->diff($duration_a_night);
							$duration_intervals_night = $duration_interval_night ->format("%h");

							$duration_time = $duration_intervals_night;
					 
					 
					 		//round up time next hour
							$datetime = DateTime::createFromFormat('H:??', $current_time);
							$current_times=$datetime->modify('next hour')->format('H:i');
							$current_times;
                        	//$current_time = date("H:i")		

							//check Max activity log
							$sql_check_log = mysqli_query($con,"SELECT MAX(logged_time) as logged_time FROM activity_log where user_id='$userid' and logged_date='$current_date' ");
							$row1_sql_check_log = mysqli_fetch_array($sql_check_log);
						 	$max_logged = $row1_sql_check_log['logged_time']; 
							$max_logged2 = strtotime($max_logged);   
						 
						 
						                     $max_lod2 = new DateTime($max_logged);
						                     $max_tm = $max_lod2->modify('next hour')->format('0G:00');
                                             $start_t69= strtotime($max_tm);
						      
							for($l=0;$l<$duration_time;$l++){
						   
						   	$duration_time;
				         	$start_time->modify('+1 hour');
				       		$st = $start_time->format('H:i');
				       		$start_t6 = strtotime($st);  

				       		switch($duration_time){
				       		case($rowCount==0):
						?>
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating"> 			
							 			<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>		
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 
						</div>
						<?php
							$l=$duration_time; //endo
							break;
							
							//
							case($rowCount==$duration_time):
							echo "<div class='modal-body' style='height:200px'>
										<div class='contianer'>	
											<div class='alert alert-danger'>
												<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
												<div class='form-group label-floating'> 					
												<div id='errorBox'>";
												echo "Sorry, you are unable to add activity, ALready reached the maximum activity logs !";
												echo "</div></div></div></div></div>";
							
							$l=$duration_time; //endo
							break;
							case($max_tm>$current_time):
						       
								    echo "<div class='modal-body' style='height:200px'>
										<div class='contianer'>	
											<div class='alert alert-danger'>
												<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
												<div class='form-group label-floating'> 					
												<div id='errorBox'>";
												echo "Sorry need to wait next hour!"; 
												echo "</div></div></div></div></div>";
						   	
						   	$l=$duration_time; //endo
                     		break;
							
							
                   case($max_tm<$current_time):
                 			
						?>																					     
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating"> 			
							 			<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>		
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 
						</div>
						<?php
						$l=$duration_time; //endo
						break;
						default:
						}
						}							
						?>
						<?php
							}
							break;
				case($current_time2>=$pm):
							if($current_time2 < $start_t2){										   
								echo "<div class='modal-body' style='height:200px'>
									<div class='contianer'>	
										<div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
											<div class='form-group label-floating'> 					
											<div id='errorBox'>";
											$aaa = new DateTime($start_t);
									 		$bbb = new DateTime($current_time);
									 		$interval_ess = $bbb->diff($aaa);
											echo "Sorry, you are unable to add activity! You still have ".$interval_ess->format("%H hour/s and %i")."min/s before your Duty";
											echo "</div></div></div></div></div>";								
							}else {
						?>
						<?php
				         	// check number of logs
				            $activity_count = mysqli_query($con,"SELECT * FROM activity_log where user_id = '$userid' AND logged_date = '$current_date'");
							//$activity_count_row = mysqli_fetch_array($activity_count);
							$rowCount = mysqli_num_rows($activity_count );
	                          
	                        //+1 hour
					     	$start_time = new DateTime($start_t);
						 
						 	//end time
						 	$endd_time = new DateTime("23:59");
						 	$endd = $endd_time->format('H:i');									 
						 
						 	//start time -1hour
							$start_pm = new DateTime($start_t);                             
							$start_pm->modify('-1 hour');
							$start_pm2 = $start_pm->format('H:i');
					 		$duration_a = new DateTime($start_pm2);                                     
                      		$duration_interval = $endd_time->diff($duration_a);
		             		$duration_intervals = $duration_interval->format("%h");
					  		$duration_time = $duration_intervals;								 
						 
					 		//round up time next hour
							$datetime = DateTime::createFromFormat('H:??', $current_time);
							$current_times=$datetime->modify('next hour')->format('H:i');
					  		$current_times;
                        	//$current_time = date("H:i")												
				
					 
	              			//check Max activity log
							$sql_check_log = mysqli_query($con,"SELECT MAX(logged_time) as logged_time FROM activity_log where user_id='$userid' and logged_date='$current_date' ");
							$row1_sql_check_log = mysqli_fetch_array($sql_check_log);										
							$max_logged = $row1_sql_check_log['logged_time']; 
							$max_logged2 = strtotime($max_logged);   	
                             
							 
							                $max_lod2 = new DateTime($max_logged);
						                    $max_tm = $max_lod2->modify('next hour')->format('H:00');
                                             $start_t69= strtotime($max_tm);

                                             if($max_tm=="00:00"){$max_tm = "23:59";}


							
							for($l=0;$l<$duration_time;$l++){										   
							   	$duration_time;
					         	$start_time->modify('+1 hour');
					       		$st = $start_time->format('H:i');
					       		$start_t6 = strtotime($st);  
					       	switch($duration_time){
					       	case($rowCount==0):
						?>
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating"> 			
							 			<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>		
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 
						</div>
						<?php
							$l=$duration_time; //endo
							break;																					
							//
							
							case($rowCount==$duration_time):
							echo "<div class='modal-body' style='height:200px'>
										<div class='contianer'>	
											<div class='alert alert-danger'>
												<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
												<div class='form-group label-floating'> 					
												<div id='errorBox'>";
												echo "Sorry, you are unable to add activity, ALready reached the maximum activity logs for the night !";
												echo "  Sorry need to wait next hour!"; 
												echo "</div></div></div></div></div>";
							
							$l=$duration_time; //endo
							break;
							case($max_tm>$current_time):
						       
								    echo "<div class='modal-body' style='height:200px'>
										<div class='contianer'>	
											<div class='alert alert-danger'>
												<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
												<div class='form-group label-floating'> 					
												<div id='errorBox'>";
												echo "Sorry need to wait next hour!"; 
												echo "</div></div></div></div></div>";
						   	
						   	$l=$duration_time; //endo
                     		break;
							
							
		    				case($max_tm<$current_time):
		    			?>																					     
						<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-6">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
										<div id="errorBox"></div>
									</div>
								</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating"> 			
							 			<input type="text"  id = "log_hour" name = "log_hour" value="<?php echo $current_time; ?>" class="form-control"readonly>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-12" id="input_fields_wrap">									
									<div class="row"> 
										<input class="btn btn-sm btn-primary col-md-10" style="width:90%" type="file" id="file1" name="myfile[]">
										<a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
									</div>
								</div>		
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 
						</div>
						<?php
							$l=$duration_time; //endo
							break;
							default:
							}					  
							}					
						?>
						<?php
							}										
							//end of AM nig
							break;
							default:	
							echo "<div class='modal-body' style='height:200px'>
						        <div class='contianer'>	
								    <div class='alert alert-danger'>
											<h5><i class='material-icons'>warning</i><strong> Error</strong></h5>
										<div class='form-group label-floating'> 					
											<div id='errorBox'>";
									   	echo "Your not on Duty, Please contact System Administrator";
									   	echo "</div></div></div></div></div>";
							} //switch bracket 
							break;
							default:
				   			}
						?>
			        </div>
			    </div>
			</div>

			<!-- Add activity Logs-->		
            <div class="panel-header panel-header-sm" >
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">  
                                    <h2 class="title">
                                    <i class="material-icons">library_books</i>
                                        <strong>Activity Logs</strong>
                                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-background-color="orange" data-target="#btn_addActivity">Add Activity</button>
                                    </h2>
                                        
                                </div>
                                
                                <div class="card-content table-responsive">
                                    <table class="table table-hover" id="tbl_userlist"  style="width:100%" >
                                        <thead class="text-primary thead-primary">
                                            <th width="25%">Fullname</th>
                                            <th width="10%">Logged Date</th>
                                            <th width="5%">Logged Time</th>
                                            <th width="45%">Activity</th>
                                            <th width="15%">Action</th>
                                        </thead>
                                        <tbody>
										<?php //SELECT t1.*, t2.* FROM t1, t2 WHERE t1.i1 = t2.i2;
                                                $sql = mysqli_query($con,"SELECT activity_log.*, users.* FROM activity_log, users WHERE activity_log.user_id = users.user_id ORDER BY log_id DESC");
                                                while($row = mysqli_fetch_array($sql)){
													$act_userid = $row['user_id'];
                                            ?>   
                                            <tr>
	                                			<td><?php echo getInfo($con, 'fullname', 'users', 'user_id',  $row['user_id']);?></td>
                                                <td><?php echo $row['logged_date'];?></td>
                                                <td><?php echo $row['logged_time'];?></td>
												<td><?php echo $row['notes'];?></td>
                                                <td>    
                                                   <input type="button" name="view" class="btn btn-danger btn-xs" value="view" onClick="updateActivity(<?php echo $row['log_id']; ?>, 'view')">												
													<?php
													    if($userid == $act_userid){
													?>
                                                    <input type="button" name="button" class="btn btn-warning btn-xs" value="update" onClick="updateActivity(<?php echo $row['log_id']; ?>)">
                                                   <?php } ?>
												   
                                                </td>
                                            </tr>
											 <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>           
        	</div>
    	</div>
    </div>
</body>

<script>
var uploadField = document.getElementById("file1");

uploadField.onchange = function() {
    if(this.files[0].size > 2000000){
       alert("File is too big! Maximum of 2MB per file");
       this.value = "";
    };
}
</script>

<?php include('scripts.php');?>

</html>
