<!-- Change Password -->
<?php
include('functions/functions.php');
include('includes/connection.php');
?>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header modal-color" >
                <h5 class="modal-title" id="addnewuser_modal">
                    <strong>Change Password</strong>
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style="color:#fff">
                    <span aria-hidden="true">&times;</span>
                </button>
                </h5>                
            </div>
            <div class="modal-body">
                <form method = "POST" id="change-pass">
                    <div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Current Password</label>
                        <input type="password" name = "old_password" id="old_password" class="form-control" required>
                         <div id="oldpass_msg" style = "display:none; width:100%;margin-top:0px;text-align:center;color:red;">
                            <h6 style="color:red">Old Password Incorrect!</h6>
                        </div>
                    </div>
                    <br>
                    <div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">New Password</label>
                        <input type="password" id="new_password" name = "new_password" class="form-control password" required>
                    </div>
                    <div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" name='confirm_password' id="confirm_password" class="form-control confirm_password"  required>
                     <!--onchange = "val_cpass()"   <div id="cpass_msg" style = "display:none; width:100%;margin-top:0px;text-align:center;color:red;">
                            <h6 style="color:red">Confirm Password not Match!</h6>
                        </div> -->
                        <div id="cpass_msg" style = "display:none; width:100%;margin-top:0px;text-align:center;color:red;">
                            <h6 style="color:red">Confirm Password not Match!</h6>
                        </div>
                    </div>
                    <div class="modal-footer" data-background-color="blue">
                        <button type="button" class="btn btn-info"  onclick="return Validate()">Save Changes</button>
                    </div>
                    <input type='hidden' name='userid' value='<?php echo $userid; ?>'>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/*function val_cpass() {
    var password = $(".password").val();
    var confirm_password = $(".confirm_password").val();

    if(password != confirm_password) {
        $("#cpass_msg").show();
        $("#cpass_msg").html("Confirm password not match!");
        // $("#btn_save").hide();
    }
    else{
        $("#cpass_msg").hide();
        $("#btn_save").show();
    }
}*/
function Validate() {
   
   var data = $("#change-pass").serialize();

   $.ajax({
         data: data,
         type: "post",
         url: "change_pass.php",
         success: function(output){
          /*document.location='uploadfiles.php?id='+output;*/
         var output = output.trim()
         if(output == "Not"){
            $("#cpass_msg").show();
         } else if(output == "Old"){
            $("#oldpass_msg").show();
         } else if(output == "Success"){
            alert('Password successfully changed!');
            window.location = 'dashboard.php';
         }
        //  document.location='dashboard.php';
       }
    });
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
<style>
    #errorBox{
        color:red;
        font-size:12px;
        font-style:italic;
    }
    #errorBox1{
        color:red;
        font-size:12px;
        font-style:italic;
    }
    #errorBox3{
        color:red;
        font-size:12px;
        font-style:italic;
    }
    #errorBox4{
        color:red;
        font-size:12px;
        font-style:italic;
    }
</style>


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
               
			   <form>                    
                    
					<div class="form-group label-floating hr_nomarg2">
                        <label class="control-label">Employee</label>
                         <select class="form-control">
						   <?php 
                                $sql = $con->query("SELECT * FROM users");
                                while($row = mysqli_fetch_array($sql)){
	                               $name = $row['fullname'];
	                               echo "<option>$name</option>";
                                }						 
		                     ?>				
					   </select>
                    </div>
					
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Start Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">End Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">Start Time (hour)</label>
                                <select class="form-control">
                                   <?php echo get_times(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group label-floating hr_nomarg2">
                                <label class="">End Time (hour)</label>
                                <select class="form-control">
                                    <?php echo get_times(); ?>
                                </select>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group hr_nomarg2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Remarks</label>
                                    <textarea class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr class="hr_nomarg">
            <div class="modal-footer" data-background-color="blue">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" >Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Schedule -->

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
            <div class="modal-body">
                <form method = "POST" name = "adduser" id = "add-user">
                    <div class="col-md-12">
                        <label >Date</label>
                        <div class="form-group label-floating hr_nomarg2">                        
                            <input type="date" id = "fullname" name = "fullname" class="form-control" required>
                            <div id="errorBox"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Time (hour)</label>
                        <div class="form-group label-floating hr_nomarg2">                            
                            <select class="form-control" id = "status" name = "status" required>
                                <option value = "Active">24</option>
                                <option value = "Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Time (min)</label>
                        <div class="form-group label-floating hr_nomarg2">                            
                            <select class="form-control" id = "status" name = "status" required>
                                <option value = "Active">59</option>
                                <option value = "Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group hr_nomarg2">
                            <div class="form-group label-floating">
                                <label class="control-label">Activity</label>
                                <textarea class="form-control" rows="5"></textarea>
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

