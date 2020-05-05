<?php include('header.php');
 $userid=$_SESSION['userid'];
	 $usertayp=$_SESSION['usertype'];
	   $user_name = $_SESSION['fullname'];
       if(isset($_POST['updateSched'])){
       updateSched($con,$_POST);
	   }
		?>
		
<script type="text/javascript">
    function updateSched(sched_id){
      window.open('update_sched.php?id='+sched_id, '_blank', 'width=600,height=500');
    }
	
	
	
	function addSched(){
    var data = $("#add-sched").serialize();
   
   $.ajax({
        data: data,
        type: "post",
        url: "sked_edit.php",
        success: function(output){
          
            var output = output.trim()
            if(output == "Success"){
                alert('Schedule successfully added!');
                window.location = 'sched_logs.php';
            }
       
        }
    });
}


function checkSched(){
   var userid =document.getElementById('userid').value;
   var startdate =document.getElementById('start_date').value;
   var data='id='+userid+'&startdate='+startdate;
   
    $.ajax({
        data: data,
        type: "post",
        url: "sched_exist.php",
        success: function(output){
        
            var output = output.trim()

            if(output == "error"){
                $("#sched_msg").show();
                $("#sched_msg").html("You already plotted a schedule for this date and user.");
                 document.getElementById("myBtn").disabled = true;
            }
            else{
                $("#sched_msg").hide();
                 document.getElementById("myBtn").disabled = false;
            }
        
        }
    });

}
</script>

<body>


    <div class="wrapper">
        <?php include('sidebar.php');  
         ?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php include('navbar.php');?>
			
			<!-- Add Schedule -->
<div class="modal fade" id="btn_addschedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-color" >
                <h5 class="modal-title" id="exampleModalLabel">
                    <strong>ADD SCHEDULE</strong>
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="color:#fff">
                    <span aria-hidden="true">&times;</span>
                </button>
                </h5>                
            </div>
            <hr class="hr_nomarg">
            <div class="modal-body">
                <form method="POST" id = "add-sched" name = "add-sched">                     
					<div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Employee</label>
                        <select class="form-control" name = "userid" id="userid" required>
                            <?php 
                                $sql = $con->query("SELECT * FROM users");
                                while($row = mysqli_fetch_array($sql)){
                                    $name = $row['fullname'];
									 $id = $row['user_id'];
                                    echo "<option value='$id'>$name</option>";
                                }						 
                            ?>				
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Start Date</label>
                                <input type="date" class="form-control" name = "start_date" id="start_date" onchange="checkSched()" required >
                                <div id='sched_msg' class='error_msg'></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">End Date</label>
                                <input type="date" class="form-control" name = "end_date" required>
								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Start Time (hour)</label>
                                <select class="form-control" name = "start_time" required>
                                   <?php echo get_times(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">End Time (hour)</label>
                                <select class="form-control" name = "end_time" required>
                                    <?php echo get_times(); ?>
                                </select>
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-lg-2" style="border-right:1px solid #d2d2d2">
                            <div class="form-group label-floating">
                                <label>Night Shift</label>
                                <input type="checkbox" name="chk_nshft" id="chk_nshft" class="form-control" value='1'>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group hr_nomarg2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Remarks</label>
                                    <textarea class="form-control" rows="5" name = "remarks"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="hr_nomarg">
                <div class="modal-footer" data-background-color="blue">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="myBtn" onClick = "addSched()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Schedule -->
			
            <div class="panel-header panel-header-sm" >
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">  
                                    <h2 class="title">
                                    <i class="material-icons" style="font-size:35px">content_paste</i>
                                        <strong>Schedule Logs</strong>
                                       <?php if($usertayp=='Admin'){?> <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-background-color="orange" data-target="#btn_addschedule">Add Schedule</button>
									   <?php } ?>
									</h2>
                                    
                                </div>
                                
                                <div class="card-content table-responsive">
                                    <table class="table table-hover" id="tbl_schedlogs"  style="width:100%;" >
                                        <thead class="text-primary thead-primary">
                                            <th>Fullname</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Remarks</th>
                                           <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php //SELECT t1.*, t2.* FROM t1, t2 WHERE t1.i1 = t2.i2;
                                                $sql = mysqli_query($con,"SELECT schedule_logs.*, users.* FROM schedule_logs, users WHERE schedule_logs.user_id = users.user_id ORDER BY sched_id DESC");
                                                while($row = mysqli_fetch_array($sql)){
                                            ?>   
                                            <tr>
                                                <td width="20%"><?php echo $row['fullname'];?></td>
                                                <td width="10%"><?php echo $row['sched_date'];?></td>
												<td width="5%"><?php echo $row['start_hr'];?></td>
												<td width="5%"><?php echo $row['end_hr'];?></td>
												<td width="35%"><?php echo $row['remarks'];?></td>
                                                
                                                <td width="15%">
												<?php if($usertayp=='Admin'){?>
												<form method="POST" action="delete.php">
												<input type="hidden" name="sched_id" value="<?php echo $row['sched_id']; ?>">
												  <input type="button" name="button" class="btn btn-warning btn-xs" value="update" onClick="updateSched(<?php echo $row['sched_id']; ?>)">
												    <input type="submit" onclick = "return confirm('You are about to DELETE this Schedule. Are you sure?')" name="delete" class="btn btn-danger btn-xs" value="delete">
                                                     </form>													
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
            <!-- Button trigger modal -->



            <!-- <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul>
                            <li>
                                <a href="https://www.creative-tim.com">
                                    Creative Tim
                                </a>
                            </li>
                            <li>
                                <a href="http://presentation.creative-tim.com">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="http://blog.creative-tim.com">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, Designed by
                        <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
                        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                    </div>
                </div>
            </footer> -->
        </div>
    </div>
</body>
<?php
if(isset($_POST['sched_id'])){
	foreach($_POST as $var=>$value)
            $$var = mysqli_real_escape_string($con,$value);
	
	
	$delete = $con->query("DELETE FROM schedule_logs WHERE sched_id='$sched_id'");
			 
		          	
			        if($delete){
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=sched_logs.php\">";
        }
			
			 
			
	
	
}
?>

<?php include('scripts.php');?>

</html>
