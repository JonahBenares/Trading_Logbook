<div class="sidebar" data-color="orange" data-image="assets/img/sidebar-6.jpg">
    <div class="logo">
        <a href="" class="simple-text btn btn-warning" style="color:#fff" >
        <i class="material-icons">explicit</i>
        Trading Logbook
        </a>
    </div>
	
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li >
                <a href="dashboard.php">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
			<?php
			 $usertayp=$_SESSION['usertype'];
			if($usertayp=='Admin'){
			?>
            <li>
                <a href="userlist.php">
                    <i class="material-icons">person</i>
                    <p>Users</p>
                </a>
            </li>
			<?php } ?>
            <li>
                <a href="sched_logs.php">
                    <i class="material-icons">content_paste</i>
                    <p>Schedule</p>
                </a>
            </li>
            <li>
                <a href="activity_logs.php">
                    <i class="material-icons">library_books</i>
                    <p>Activity Log</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <i class="material-icons">insert_drive_file</i>
                    <p>Reports</p>
                </a>
                <ul class="collapse" id="multiCollapseExample1" style="padding-left: 75px;margin-top: 10px;list-style:none;" >    
                    <a href="reports.php" style="color:#3C4858!important;">
                        <p>Schedule Reports</p>
                    </a>                
                    <a href="activity_reports.php" style="color:#3C4858!important;">
                        <p>Activity Log Reports</p>
                    </a>                 
                </ul>
            </li>
            <li>
                <a href="logout.php">
                    <i class="material-icons">power_settings_new</i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- <p>
                                  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                                  
                                </p>
                                <div class="row">
                                  <div class="col">
                                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                                      <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div> -->