<!-- Change Password -->
<?php
include('functions/functions.php');
include('includes/connection.php');
 include('scripts.php');
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
    .error_msg{
        color:red;
        font-size:12px;
        font-style:italic;
    }
</style>










<script>
var uploadField = document.getElementById("file1");

uploadField.onchange = function() {
    if(this.files[0].size > 307200){
       alert("File is too big!");
       this.value = "";
    };
}
</script>

<!-- Add New User -->

