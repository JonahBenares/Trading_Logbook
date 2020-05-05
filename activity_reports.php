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
      window.open('update_activity.php?id='+log_id+'&view='+view, '_blank', 'width=600,height=500');
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
            $(wrapper).append('<div><input class="btn btn-sm btn-default " style="width:100%" type="file" id="file'+x+'" name="myfile[]"><a href="#" class="remove_field">Remove</a></div>'); //add input box

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
        
            var output = output.trim()
            if(output == "Success"){
                alert('Activity successfully added!');
                window.location = 'activity_logs.php';
            }
        
        }
		
    });
}
</script>
<style type="text/css">
    #name-type{float:left;list-style:none;margin-top:-3px;padding:0;width:350px;position: absolute; z-index:100;}
    #name-type li:hover {
        background: #28422c;
        cursor: pointer;
        font-weight: bold;
        color: white;
    }
    #name-type li {
        padding: 5px;
        background-color: #b5e8bb;
        border-bottom: #bbb9b9 1px solid;
        border-radius: 10px;
        width:70%;
    }
    #search-fullname{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
    .search{
      color:green;
      font-weight: bold;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){;
    $("#fullname").keyup(function(){
        $.ajax({
        type: "GET",
        url: "search-fullname.php",
        data:'fullname='+$(this).val(),
        beforeSend: function(){
          $("#fullname").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
        },
        success: function(data){
          $("#suggestion-fullname").show();
          $("#suggestion-fullname").html(data);
          $("#fullname").css("background","#FFF");
        }
        });
    });
});
function selectFullname(val,id) {
    $("#fullname").val(val);
    $("#userid").val(id);
    $("#suggestion-fullname").hide();
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
					$current_time2 =  strtotime($current_time);
	                $end_t2 = strtotime($end_t);
					$start_t2 = strtotime($start_t);   
					$end_t2_d = date($end_t);
					$start_t2_d = date($start_t);   
					//+1 day
					$sched_d_minus1 = new DateTime($sched_d);
                    $sched_d_minus1 ->modify('-1 day');	
				?>
                <?php
		       		switch ($current_date) {
				    case ($current_date!=$sched_d):
			  	?> 
				<div class="modal-body" style="height:200px">
					<div class="contianer">	
						<div class="col-md-12">
							<label >Error</label>
							<div class="form-group label-floating "> 					
								<div id="errorBox">
								<?php
				        echo $sched_d;
						
					  ?> Your not On-Duty, Please Contact System Administrator</div>
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
							<div class='col-md-12'>
							<label >Error</label>
							<div class='form-group label-floating'> 					
							<div id='errorBox'>";
						  	$aaa = new DateTime($start_t);
                            $bbb = new DateTime($current_time);
                            $interval_ess = $bbb->diff($aaa);
							echo "Sorry, you are unable to add activity! You still have ".$interval_ess->format("%H hour/s and %i")."min/s before your Duty";
							echo "</div></div></div></div></div>";
						}
						else if($current_time2 > $end_t2){
							echo "<div class='modal-body' style='height:200px'>
							<div class='contianer'>	
							<div class='col-md-12'>
							<label >Error</label>
							<div class='form-group label-floating'> 					
							<div id='errorBox'>";
							$a_a = new DateTime($end_t);
							$b_b = new DateTime($current_time);
							$interval_ab = $a_a->diff($b_b);
						   	echo "Sorry, you are unable to add activity! You already exceed/s ".$interval_ab->format("%H hour/s and %i")."min/s on your Duty Time out";
						   	echo " Or the admin Plotted a wrong schedule.!!";
						   	echo "</div></div></div></div></div>";   
					    }
					    else{
					?>
							<div class="modal-body">
							<form method = "POST" name = "add-activity" id = "add-activity">
								<div class="col-md-12">
									<label >Dates</label>
									<div class="form-group label-floating "> 
										<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid; ?>" class="form-control">	
										<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
									<div id="errorBox"></div>
								</div>
							</div>
								<div class="col-md-6">
									<label>Time (hours)</label>
									<div class="form-group label-floating hr_nomarg2">    
	                                
											<select class="form-control" id = "log_hour" name = "log_hour" required>
											<?php echo get_times2($current_time, $end_t); ?>
											</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group hr_nomarg2">
										<div class="form-group label-floating">
											<label class="control-label">Activity</label>
											<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
										</div>
									</div>
								</div> 
								<div class="col-md-6" id="input_fields_wrap">
									<button id="add_field_button">Add More Fields</button>
									<div>
										<input class="btn btn-sm btn-default " style="width:100%" type="file" id="file1" name="myfile[]">
									</div>
								</div>						
								</div>	
								<hr class="hr_nomarg">
								<div class="modal-footer" data-background-color="blue">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-info" onClick="addActivity()">Save changes</button>
								</div>
								<input type='hidden' name='counter' id='counter'>
							</form> 	
						<?php }
						//Night Shift
						break;
						case ($current_date==$sched_d && $night_shift==1 ):
						if($current_time2 <= $start_t2 ){
							echo "<div class='modal-body' style='height:200px'>
							<div class='contianer'>	
							<div class='col-md-12'>
							<label >Error</label>
							<div class='form-group label-floating'> 					
							<div id='errorBox'>";
							$aa = new DateTime($start_t);
							$bb = new DateTime($current_time);
							$interval_es = $bb->diff($aa);
							echo "Sorry, you are unable to add activity! You still have".$interval_es->format("%H hour/s and %i")."min/s before your Dutyert";
							echo "</div></div></div></div></div>";
						}
						else if($current_time2 > $end_t2){		
						echo "<div class='modal-body' style='height:200px'>
						<div class='contianer'>	
						<div class='col-md-12'>
						<label >Error</label>
						<div class='form-group label-floating'> 					
						<div id='errorBox'>";	
						$a = new DateTime($end_t);
						$b = new DateTime($current_time);
						$interval = $a->diff($b);
						echo "Sorry, you are unable to add activity! You already exceed/s ".$interval->format("%H hour/s and %i")."min/s on your Duty Time outs";
						echo "</div></div></div></div></div>";
			        }
			        else{		   
				?>
				<div class="modal-body">
					<form method = "POST" name = "add-activity" id = "add-activity">
					<div class="col-md-12">
						<label >Dates</label>
						<div class="form-group label-floating "> 
						<input type="hidden" id = "userid" name = "userid" value="<?php echo $userid;?>" class="form-control" required>	
						<input type="text" id = "log_date" name = "log_date" class="form-control" value="<?php echo $current_date;?>" readonly>
						<div id="errorBox"></div>
					</div>
				</div>
				<div class="col-md-6">
					<label>Time (hours)</label>
					<div class="form-group label-floating hr_nomarg2">    
						<select class="form-control" id = "log_hour" name = "log_hour" required>
							<?php echo get_times2($current_time, $end_t); ?>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group hr_nomarg2">
						<div class="form-group label-floating">
							<label class="control-label">Activity</label>
							<textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
						</div>
					</div>
				</div> 
				<div class="col-md-6" id="input_fields_wrap">
					<button id="add_field_button">Add More Fields</button>
					<div>
						<input class="btn btn-sm btn-default " style="width:100%" type="file" id="file1" name="myfile[]" required>
					</div>
				</div>										
				</div>	
				<hr class="hr_nomarg">
				<div class="modal-footer" data-background-color="blue">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info" onClick="addActivity()">Save changes</button>
				</div>
				<input type='hidden' name='counter' id='counter'>
			</form> 
			<?php
				}
		   		break;
				default:
				}		   
			?>	
        </div>
    </div>
</div>
<!-- Add activity Logs-->
<div class="panel-header panel-header-sm" ></div>
	<div class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-md-12">
	            	<form method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating hr_nomarg2">
                                            <label class="">Fullname</label>
                                            <input type = "text" id = "fullname" name = "fullname" class = "form-control" autocomplete="off">
                                            <span id="suggestion-fullname"></span>
                                            <input type = "hidden" id = "userid" name = "userid">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating hr_nomarg2">
                                            <label class="">Date From</label>
                                            <input type = "date" id = "date_from" name = "date_from" class = "form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating hr_nomarg2">
                                            <label class="">Date To</label>
                                            <input type = "date" id = "date_to" name = "date_to" class = "form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating hr_nomarg2">
                                            <input type = "submit" id = "submit" name = "submit" class = "btn btn-info btn-md" value = "Search">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php 
                                $sql = "SELECT * FROM activity_log";
                                $url="";
                                if(!empty($_GET)){
                                    $sql .= " WHERE"; 
                                    if(!empty($_GET['userid'])){
                                        $sql .= " user_id =  '$_GET[userid]' AND";
                                        $url.="user_id=".$_GET['userid'];
                                    }
                                    if(!empty($_GET['date_from'])){
                                        if(!empty($_GET['date_to'])){
                                            $sql .= " logged_date BETWEEN '$_GET[date_from]' AND '$_GET[date_to]' AND";
                                            $url.="datefrom=".$_GET['date_from']."&dateto=".$_GET['date_to'];
                                        }else{
                                            $sql .= " logged_date BETWEEN '$_GET[date_from]' AND '$_GET[date_from]' AND";
                                            $url.="datefrom=".$_GET['date_from']."&dateto=".$_GET['date_from'];
                                        }
                                    }
                                }
                                $q = substr($sql,-3);
                                if($q == 'AND'){
                                    $sql = substr($sql,0,-3);
                                }
                                $query = mysqli_query($con,$sql);
                            ?>
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
	                            	<th>Fullname</th>
	                                <th>Logged Date</th>
	                                <th>Logged Time</th>
	                                <th>Activity</th>
	                                <th>Action</th>
	                            </thead>
	                            <tbody>
									<?php //SELECT t1.*, t2.* FROM t1, t2 WHERE t1.i1 = t2.i2;
	                                    /*$sql = mysqli_query($con,"SELECT activity_log.*, users.* FROM activity_log, users WHERE activity_log.user_id = users.user_id ORDER BY log_id DESC");*/
	                                    while($row = mysqli_fetch_array($query)){
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
	    <!-- Button trigger modal -->
	</div>
</div>
</body>
<script>
var uploadField = document.getElementById("file1");

uploadField.onchange = function() {
    if(this.files[0].size > 307200){
       alert("File is too big!");
       this.value = "";
    };
}
</script>
<?php include('scripts.php');?>
</html>
