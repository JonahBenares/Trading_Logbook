<?php 
    include 'header.php';
	 $user_name = $_SESSION['fullname'];
    if(isset($_POST['updateuser'])){
        updateUser($con,$_POST);
    }
?>
<script type="text/javascript">

    function updateUser(user_id){
      window.open('update_user.php?id='+user_id, '_blank', 'width=600,height=500');
    }
	
   function addUser(){
    var  fullname = document.getElementById("fullname").value;
    var  username = document.getElementById("username").value;
    var  usertype = document.getElementById("usertype").value;
    var  status = document.getElementById("status").value;
    if(fullname == "" ){
        document.getElementById("fullname").focus();
        document.getElementById("errorBox").innerHTML="Error: Enter Fullname";
        return false;
    } 
    else if(username == "" ){
        document.getElementById("username").focus();
        document.getElementById("errorBox1").innerHTML="Error: Enter Username";
        return false;
    } 
    else if(usertype == "" ){
        document.getElementById("usertype").focus();
        document.getElementById("errorBox3").innerHTML="Error: Select Usertype";
        return false;
    }  
    else if(status == "" ){
        document.getElementById("status").focus();
        document.getElementById("errorBox4").innerHTML="Error: Select Status";
        return false;
    }
    else {
        var data = $("#add-user").serialize();
        $.ajax({
             data: data,
             type: "post",
             url: "add_user.php",
             success: function(output){
                var output = output.trim()
                if(output == "Invalid"){
                    $("#user_msg").show();
                }
                else if(output == "Success") {
                    alert('User successfully registered!');
                    window.location = 'userlist.php';
                }
            }
        });
    }
}	
	
	
</script>
<body>
    <div class="wrapper">
        <?php include('sidebar.php');?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php include('navbar.php');?>
			
			
			
<!-- Add New User -->
<div class="modal fade" id="btn_adduser" tabindex="-1" role="dialog" aria-labelledby="addnewuser_modal" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-color" >
                <h5 class="modal-title" id="addnewuser_modal">
                    <strong>ADD USER</strong>
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="color:#fff">
                    <span aria-hidden="true">&times;</span>
                </button>
                </h5>                
            </div>
            <hr class="hr_nomarg">
            <div class="modal-body">
                <form method = "POST" name = "adduser" id = "add-user">
                    <div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Full Name</label>
                        <input type="text" id = "fullname" name = "fullname" class="form-control" required>
                        <div id="errorBox"></div>
                    </div>
                    <div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" id = "username" class="form-control" autocomplete="off" required>
                        <div id="user_msg" style = "display:none; width:100%;margin-top:0px;text-align:center;color:red;">
                            <h6 style="color:red">Username Already Taken!</h6>
                        </div>
                        <div id="errorBox1"></div>
                        <span id="suggestion-username"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Usertype</label>
                                <select class="form-control" id = "usertype" name = "usertype" required>
                                    <option value = "1">Admin</option>
                                    <option value = "2">Staff</option>
                                </select>
                                <div id="errorBox3"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Status</label>
                                <select class="form-control" id = "status" name = "status" required>
                                    <option value = "Active">Active</option>
                                    <option value = "Inactive">Inactive</option>
                                </select>
                                <div id="errorBox4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="hr_nomarg">
                <div class="modal-footer" data-background-color="blue">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" onClick="addUser()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add New User -->
			
			
            <div class="panel-header panel-header-sm" >
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">  
                                    <h2 class="title">
                                    <i class="material-icons" style="font-size:35px">person</i>
                                        <strong>User List</strong>
                                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-background-color="orange" data-target="#btn_adduser">Add User</button>
                                    </h2>
                                    
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover" id="tbl_userlist"  style="width:100%" >
                                        <thead class="text-primary thead-primary">
                                            <th>Fullname</th>
                                            <th>Username</th>
                                            <th>Usertype</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $sql = mysqli_query($con,"SELECT * FROM users ORDER BY user_id DESC");
                                                while($row = mysqli_fetch_array($sql)){
                                            ?>    
                                            <tr>
                                                <td><?php echo $row['fullname'];?></td>
                                                <td><?php echo $row['username'];?></td>
                                                <td><?php echo getInfo($con, 'usertype_name', 'usertype', 'usertype_id',  $row['usertype_id']);?></td>
                                                <td>
                                                <?php if($row['status'] == 'Active') { ?>
                                                    <span class="label label-success">Active</span></td>
                                                <?php } else { ?>
                                                    <span class="label label-danger">Inactive</span></td>
                                                <?php } ?>
                                                </td>
                                                <td> 
                                                    <button name="button" class="btn btn-info btn-xs" value="update" onClick="updateUser(<?php echo $row['user_id']; ?>)">Update</button>
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

<?php include('scripts.php');?>

</html>
