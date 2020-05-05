<?php include('header.php');
    $userid=$_SESSION['userid'];
    $usertayp=$_SESSION['usertype'];
    $user_name = $_SESSION['fullname'];
    if(isset($_POST['updateSched'])){
        updateSched($con,$_POST);
    }
?>	
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
        <?php include('sidebar.php'); ?>
        <div class="main-panel">
            <!-- Navbar -->
        <?php include('navbar.php');?>			
        <div class="panel-header panel-header-sm"></div>
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
                                $sql = "SELECT * FROM schedule_logs";
                                $url="";
                                if(!empty($_GET)){
                                    $sql .= " WHERE"; 
                                    if(!empty($_GET['userid'])){
                                        $sql .= " user_id =  '$_GET[userid]' AND";
                                        $url.="user_id=".$_GET['userid'];
                                    }
                                    if(!empty($_GET['date_from'])){
                                        if(!empty($_GET['date_to'])){
                                            $sql .= " sched_date BETWEEN '$_GET[date_from]' AND '$_GET[date_to]' AND";
                                            $url.="datefrom=".$_GET['date_from']."&dateto=".$_GET['date_to'];
                                        }else{
                                            $sql .= " sched_date BETWEEN '$_GET[date_from]' AND '$_GET[date_from]' AND";
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
                                                /*$sql1 = mysqli_query($con,"SELECT schedule_logs.*, users.* FROM schedule_logs, users WHERE schedule_logs.user_id = users.user_id ORDER BY sched_id DESC");*/
                                                while($row = mysqli_fetch_array($query)){ 
                                            ?>   
                                            <tr>
                                                <td><?php echo getInfo($con, 'fullname', 'users', 'user_id',  $row['user_id']);?></td>
                                                <td><?php echo $row['sched_date'];?></td>
												<td><?php echo $row['start_hr'];?></td>
												<td><?php echo $row['end_hr'];?></td>
												<td><?php echo $row['remarks'];?></td>
                                                
                                                <td>
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
