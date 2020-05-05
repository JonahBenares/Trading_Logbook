<?php 
    include 'header.php';
    include 'functions/functions.php';
    $userid=$_SESSION['userid'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        $id = '';
    }
    if(isset($_POST['updatesked'])){
		date_default_timezone_set("Asia/Manila");
       $current =  date("Y-m-d").' '. date("H:i:s");
        foreach($_POST as $var=>$value)
            $$var = mysqli_real_escape_string($con,$value);

        $update = $con->query("UPDATE schedule_logs SET sched_date = '$sched_date', start_hr = '$start_time', date_plotted='$current', end_hr = '$end_time', remarks = '$remarks', night_shift = '$chk_nshft' WHERE sched_id = '$id'");
        if($update){
            echo "<script>alert('Successfully Updated!'); window.opener.location.reload(); window.close();</script>";
        }
    }
?>
<style type="text/css"> 
    .main-panel>.content{
        margin-top: 0px!important;
    }
    @media (max-width: 991px){
    .form-group .form-con {
        font-size: auto;
        height: auto;
    }}
</style>
<body>
    <div class="wrapper">
        <div class="main-panel">
            <div class="content" >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" data-background-color="orange">  
                                    <h2 class="title">
                                    <i class="material-icons" style="font-size:35px">person</i>
                                        <strong>Update Schedule</strong>
                                    </h2>                                    
                                </div>
                                <div class="card-content table-responsive">
                                    <?php 
                                        $sql2 = mysqli_query($con,"SELECT * FROM schedule_logs WHERE sched_id = '$id'");
                                        $row2 = mysqli_fetch_array($sql2);
										
										$sked_user_id = $row2['user_id'];
										$sked_sched_id = $row2['sched_id'];
										
										 $sql = mysqli_query($con,"SELECT schedule_logs.*, users.* FROM schedule_logs, users WHERE users.user_id = '$sked_user_id' and schedule_logs.sched_id = '$sked_sched_id' ");
                                        $row = mysqli_fetch_array($sql);
                                    ?>
                                    <form method="POST">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Fullname</label>
                                                <input type="text" name = "fullname" class="form-control" style="width:100%" value = "<?php echo $row['fullname'];?>" readonly>
												<input type='hidden' name='sched_id' value="<?php echo $sked_sched_id; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Start Date</label>
                                <input type="date" class="form-control" name = "sched_date" value="<?php echo $row['sched_date'];?>" required>
                            </div>
                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Start Time</label>
												                <select class="form-control" name = "start_time" required>
									 <option value= "<?php echo $row['start_hr'];?>" selected><?php echo $row['start_hr'];?></option>			
                                     <option value= "<?php echo get_times(); ?>"></option>
                                        </select>
                                               
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">End Time</label>
                                                <select class="form-control" name = "end_time" required>
									 <option value= "<?php echo $row['end_hr'];?>" selected><?php echo $row['end_hr'];?></option>			
                                   <option value= "<?php echo get_times(); ?>"></option>
                                </select>
								
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-xs-2" style="border-right:1px solid #d2d2d2">
                                                <div class="form-group label-floating">
                                                    <label>Night Shift</label>
													<?php if($row['night_shift'] == 1){?>
                                                    <input type="checkbox" name="chk_nshft" id="chk_nshft" class="form-control" value='1' checked>
													<?php } ?>
													<?php if($row['night_shift'] == 0){?>
                                                    <input type="checkbox" name="chk_nshft" id="chk_nshft" class="form-control" value='1'>
													<?php } ?>
                                                </div>
                                            </div>
											
                                            <div class="col-xs-10">
                                                <div class="form-group hr_nomarg2">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Remarks</label>
                                                        <textarea class="form-control form-con"  name = "remarks" rows="5" style="width:100%" ><?php echo $row['remarks'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <center>
                                            <input type="submit" class="btn btn-info" value = "Save Changes" name = "updatesked">
                                        </center>
                                        
                                        
                                    </form>
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

<?php include('scripts.php');?>

</html>
