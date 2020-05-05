
<?php
include('functions/functions.php');
include('includes/connection.php');

$userid=$_SESSION['userid'];
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

<script type="text/javascript">
     
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



</script>
