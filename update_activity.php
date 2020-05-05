    <?php 
        error_reporting(E_ERROR | E_PARSE);
        include 'header.php';
        include 'functions/functions.php';
    	include('scripts.php');
        $userid=$_SESSION['userid'];
        if(isset($_GET['id'])){
            $id = $_GET['id'];
    		$view=$_GET['view'];
        } else {
            $id = '';
        }
        if(isset($_POST['updateactivity'])){
    		date_default_timezone_set("Asia/Manila");
           $current =  date("Y-m-d").' '. date("H:i:s");
            foreach($_POST as $var=>$value)
                $$var = mysqli_real_escape_string($con,$value);

            $update = $con->query("UPDATE activity_log SET logged_date = '$logged_date', logged_time = '$logged_time', encoded_date='$current', notes = '$notes' WHERE log_id = '$id'");
    	   if($update){
              echo "<script>alert('Successfully Updated!'); window.opener.location.reload(); window.close();</script>";
           }
        }        	
    	// echo "<script>alert('Successfully Updated!'); window.opener.location.reload(); window.close();</script>";    	
    ?>
    <?php
        if($id !== null && $view==='undefined'){
    ?>
    <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $("#input_fields_wrap"); 
            var add_button      = $("#add_field_button"); 
            
            var x = 1; 
            $(add_button).click(function(e){ 
                e.preventDefault();
                if(x < max_fields){ //max input box 
                    x++; 
                    $(wrapper).append('<div class="row" style="padding:0px 30px 0px 30px"><input class="btn btn-sm btn-primary col-xs-6" style="width:90%" type="file" id="file'+x+'" name="myfile[]"><a href="#" class="remove_field" style="10%"><i class="material-icons">clear</i></a></div>'); 
                              
                                uploadField.onchange = function() {
                if(this.files[0].size > 2000000){
                   alert("File is too big! Maximum of 2MB per file");
                   this.value = "";
                };
            }

                    //add input box
                    // <div class="row"><input class="btn btn-sm btn-primary col-xs-6" style="width:80%" type="file" id="file'+x+'" name="myfile[]"> <a class="col-xs-6" id="add_field_button" style="width:10%"><i class="material-icons">clear</i></a> </div>
                }
               document.getElementById('counter').value = x;
            });
            
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
        function updateActivity(){
           // var data = $("#add-activity").serialize();
           var input, file;
           counter = document.getElementById('counter').value;
            log_id2 = document.getElementById('log_id2').value;

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


                   


            $.ajax({
                data: frm,
                type: "post",
                url: "update_uploads.php?id="+log_id2,
                contentType: false,
                processData: false,
                cache: false,
                success: function(output){
                
                    var output = output.trim()
                    if(output == "Success"){
                        alert('Activity successfully added!');
                        window.location = 'update_activity.php';
                    }
                
                }
            });
        }
    </script>

    <style type="text/css"> 
        .main-panel>.content{
            margin-top: 0px!important;
        }
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
                                            <strong>Update Activity </strong>
                                        </h2>                                    
                                    </div>
                                    <div class="card-content table-responsive">
                                        <?php 
                                            $sql2 = mysqli_query($con,"SELECT * FROM activity_log WHERE log_id = '$id'");
                                            $row2 = mysqli_fetch_array($sql2);
    										
    										$log_user_id = $row2['user_id'];
    										 $activity_log_id = $row2['log_id'];
    										
    										 $sql = mysqli_query($con,"SELECT activity_log.*, users.* FROM activity_log, users WHERE users.user_id = '$log_user_id' and activity_log.log_id = '$activity_log_id' ");
                                            $row = mysqli_fetch_array($sql);
                                        ?>
                                        <form method="POST">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fullname</label>
                                                    <input type="text" name = "fullname" class="form-control" style="width:100%" value = "<?php echo $row['fullname'];?>" readonly>
    												<input type='hidden' name='log_id' value="<?php echo $activity_log_id; ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group label-floating ">
                                                    <label class="control-label">Log Date</label>
                                                    <input type="text" class="form-control" name = "logged_date" value="<?php echo $row['logged_date'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Log Time</label>
    												<input type="text" class="form-control" name = "logged_time" value="<?php echo $row['logged_time'];?>" readonly>
                                                </div>
                                            </div>                                                                                    
    										<div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Activity</label>
                                                    <!--<input type="text" name = "notes" class="form-control" style="width:100%" value = "<?php //echo $row['notes'];?> "> -->
                                                     <textarea class="form-control" rows="5" id="notes" name="notes" style="height:30%;width:100%"><?php echo $row['notes'];?></textarea>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Attached File/s</label>                                                   
                                                </div>                                                
    										</div>                                        
    									    <div id="input_fields_wrap">
                                                <div class="row" style="padding:0px 30px 0px 30px">
                                                    <input class="btn btn-sm btn-primary col-xs-6" style="width:90%;" type="file" id="file1" name="myfile[]">
                                                    <a id="add_field_button" style="width:10%"><i class="material-icons">add</i></a>
                                                </div>
                                            </div>                                                													 	
                                            <center>
                                                <input type="submit" class="btn btn-info" onclick="updateActivity()"value = "Save Changes" name = "updateactivity">
                                            </center>                                            
                                            <input type='hidden' name='counter' id='counter'>
                                            <input type='hidden' name='log_id2' id='log_id2' value="<?php echo $id;?>">
                                        </form>
                                        <div class="col-md-12" style="border-top: 1px solid #555;padding: 10px ">
                                            <div class="">
                                                <?php 
                                                $c=1;
                                                $sql_upload = mysqli_query($con,"SELECT * FROM upload_logs WHERE log_id = '$activity_log_id'"); 
                                                while($rows=mysqli_fetch_array($sql_upload)){
                                                    $cert1=explode(".",$rows['file_name']);
                                                    $attach2 = $cert1[1];

                                                    if($attach2=='png' || $attach2=='jpg' || $attach2 == 'jpeg' || $attach2 == 'PNG' || $attach2 == 'JPG' || $attach2 == 'JPEG'){                           
                                                        ?>
                                                <div class="col-lg-3 col-md-4 col-xs-3 " style="float:left">
                                                    <img id="hase" class="thumbnail sd" src="
                                                    <?php 
                                                    if(empty($rows['file_name'])){
                                                        echo "images/default.jpg";
                                                    }
                                                    else{
                                                        echo 'images/'.$rows['file_name'];
                                                    }
                                                    ?>" style="width:80px;height: 80px" onclick="openModal();currentSlide(<?php echo $c;?>)" class="hover-shadow cursor" alt="<?php echo $rows['file_name']?>">
                                                </div>
                                                <?php } else { ?>   
                                                <div class="column" >  
                                                    <a href='images/<?php echo $rows['file_name']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='images/default.png' width="230" height="230">
                                                    <h5 class="sas" style="color:#0087ff" ><?php echo $rows['file_name']; ?></h5></a> 
                                                </div>
                                                <?php } $c++; } ?>
                                                <div id="mode" class="modal1 " >                                     
                                                    <a class="prev" onclick="plusSlides(-1)">previous</a>
                                                    <a class="nextxen" onclick="plusSlides(1)">next</a>
                                                    <span class="close cursor" onclick="closeModal()">&times;</span>
                                                    <div onclick="closeModal()">                                                
                                                        <div class="modal-content1" style="top:20px">                                          
                                                            <?php
                                                            $a = 1;
                                                            $sql3 = mysqli_query($con,"SELECT * FROM upload_logs WHERE log_id = '$activity_log_id'");
                                                            $b = mysqli_num_rows($sql3);
                                                            while ($row2 = mysqli_fetch_array($sql3)){ 
                                                                $file=explode(".",$row2['file_name']);
                                                                $attach1 = $file[1];
                                                                ?>
                                                                <div class="mySlides">                                       
                                                                    <div class="">     
                                                                        <div style="padding:50px;  margin:auto;margin-top: 0px "  >
                                                                            <div class="numbertext" ><?php echo $a.'/'.$b ?>&nbsp-&nbsp<?php echo $row2['file_name'];?>              
                                                                            </div> 
                                                                            <img src="<?php 
                                                                            if (empty($row2['file_name'])){
                                                                                echo "images/default.jpeg";
                                                                            } else{
                                                                                if($attach1 == 'jpg' || $attach1 == 'png' || $attach1 == 'jpeg'  || $attach1 == 'PNG' || $attach1 == 'PNG' || $attach1 == 'JPG' || $attach1 == 'JPEG'){
                                                                                    echo 'images/'. $row2['file_name']; 
                                                                                    } else {
                                                                                        echo "images/files.png";
                                                                                    }
                                                                                }
                                                                                ?>" style="width:100%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php $a++; }?>                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    	<script>    	
        var uploadField = document.getElementById("file1");

        uploadField.onchange = function() {
            if(this.files[0].size > 2000000){
               alert("File is too big! Maximum of 2MB per file");
               this.value = "";
            };
        }
        </script>
    </body> 

    <?php
    }if($id!==null && $view==='view'){
    ?>

    <style type="text/css"> 
        .main-panel>.content{
            margin-top: 0px!important;
        }
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
                                            <strong>View Activity </strong>
                                        </h2>                                    
                                    </div>
                                    <div class="card-content table-responsive">
                                        <?php 
                                            $sql2 = mysqli_query($con,"SELECT * FROM activity_log WHERE log_id = '$id'");
                                            $row2 = mysqli_fetch_array($sql2);
    										
    										$log_user_id = $row2['user_id'];
    										 $activity_log_id = $row2['log_id'];
    										
    										 $sql = mysqli_query($con,"SELECT activity_log.*, users.* FROM activity_log, users WHERE users.user_id = '$log_user_id' and activity_log.log_id = '$activity_log_id' ");
                                            $row = mysqli_fetch_array($sql);
                                        ?>
                                        <form method="POST">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fullname</label>
                                                    <input type="text" name = "fullname" class="form-control" style="width:100%" value = "<?php echo $row['fullname'];?>" readonly>
    												<input type='hidden' name='log_id' value="<?php echo $activity_log_id; ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group label-floating ">
                                                    <label class="control-label">Log Date</label>
                                                    <input type="text" class="form-control" name = "logged_date" value="<?php echo $row['logged_date'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Log Time</label>
    												<input type="text" class="form-control" name = "logged_time" value="<?php echo $row['logged_time'];?>" readonly>  
                                                </div>
                                            </div>                                           
    										<div class="col-xs-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Activity</label>
                                                   <!-- <input type="text" name = "notes" class="form-control" style="width:100%" value = "<?php //echo $row['notes'];?>" readonly> -->
													<textarea class="form-control" rows="5" id="notes" name="notes" style="height:30%;width:100%" readonly><?php echo $row['notes'];?></textarea>
                                                </div>    											
    											<div class="form-group label-floating">
                                                    <label class="control-label">Attached File/s</label>                                                   
                                                </div>
    											
                                                <div class="">
                                                    <?php 
                                                    $c=1;
                                                    $sql_upload = mysqli_query($con,"SELECT * FROM upload_logs WHERE log_id = '$activity_log_id'"); 
                                                    while($rows=mysqli_fetch_array($sql_upload)){
                                                        $ds=explode(".",$rows['file_name']);
                                                        $attach2 = $ds[1];

                                                        if($attach2=='png' || $attach2=='jpg' || $attach2 == 'jpeg' || $attach2 == 'PNG' || $attach2 == 'JPG' || $attach2 == 'JPEG'){                           
                                                            ?>
                                                    <div class="col-lg-3 col-md-4 col-xs-3 " style="float:left">
                                                        <img id="hase" class="thumbnail sd" src="
                                                        <?php 
                                                        if(empty($rows['file_name'])){
                                                            echo "images/default.jpg";
                                                        }
                                                        else{
                                                            echo 'images/'.$rows['file_name'];
                                                        }
                                                        ?>" style="width:80px;height: 80px" onclick="openModal();currentSlide(<?php echo $c;?>)" class="hover-shadow cursor" alt="<?php echo $rows['file_name']?>">
                                                    </div>
                                                    <?php } else { ?>   
                                                    <div class="column" >  
                                                        <a href='images/<?php echo $rows['file_name']; ?>' target='_blank'><img class=" hover-shadow cursor  thumbnail sd" src='images/default.png' width="230" height="230">
                                                        <h5 class="sas" style="color:#0087ff" ><?php echo $rows['file_name']; ?></h5></a> 
                                                    </div>
                                                    <?php } $c++; } ?>

                                                    <div id="mode" class="modal1 " >
                                                        <a class="prev" onclick="plusSlides(-1)">previous</a>
                                                        <a class="nextxen" onclick="plusSlides(1)">next</a>
                                                        <span class="close cursor" onclick="closeModal()">&times;</span>
                                                        <div onclick="closeModal()">                                                
                                                            <div class="modal-content1" style="top:20px">                                          
                                                                <?php
                                                                $a = 1;
                                                                $sql3 = mysqli_query($con,"SELECT * FROM upload_logs WHERE log_id = '$activity_log_id'");
                                                                $b = mysqli_num_rows($sql3);
                                                                while ($row2 = mysqli_fetch_array($sql3)){ 
                                                                    $crt=explode(".",$row2['file_name']);
                                                                    $attach1 = $crt[1];
                                                                    ?>
                                                                    <div class="mySlides">                                       
                                                                        <div class="">     
                                                                            <div style="padding:50px;  margin:auto;margin-top: 0px "  >
                                                                                <div class="numbertext" ><?php echo $a.'/'.$b ?>&nbsp-&nbsp<?php echo $row2['file_name'];?>              
                                                                                </div> 
                                                                                <img src="<?php 
                                                                                if (empty($row2['file_name'])){
                                                                                    echo "images/default.jpeg";
                                                                                } else{
                                                                                    if($attach1 == 'jpg' || $attach1 == 'png' || $attach1 == 'jpeg'  || $attach1 == 'PNG' || $attach1 == 'PNG' || $attach1 == 'JPG' || $attach1 == 'JPEG'){
                                                                                        echo 'images/'. $row2['file_name']; 
                                                                                        } else {
                                                                                            echo "images/files.png";
                                                                                        }
                                                                                    }
                                                                                    ?>" style="width:100%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php $a++; }?>                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type='hidden' name='counter' id='counter'>
                                                 <input type='hidden' name='log_id2' id='log_id2' value="<?php echo $id;?>">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->
            </div>
        </div>
    	
    </body>


    <?php
    }else{  //close page
    }
    ?>
    <?php include('scripts.php');?>
<script type="text/javascript">

    function openModal() {
      document.getElementById('mode').style.display = "block";
  }

  function closeModal() {
      document.getElementById('mode').style.display = "none";

  }

  var slideIndex = 1;
       // showSlides(slideIndex);

       function plusSlides(n) {
          showSlides(slideIndex += n);
      }

      function currentSlide(n) {
          showSlides(slideIndex = n);
      }

      function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          var captionText = document.getElementById("kik");
          if (n > slides.length) {slideIndex = 1}
              if (n < 1) {slideIndex = slides.length}
                  for (i = 0; i < slides.length; i++) {
                      slides[i].style.display = "none";
                  }
                  for (i = 0; i < dots.length; i++) {
                      dots[i].className = dots[i].className.replace(" active", "");
                  }
                  slides[slideIndex-1].style.display = "block";
                  dots[slideIndex-1].className += " active";
                  captionText.innerHTML = dots[slideIndex-1].alt;
              }

        //----------------------------------------------------------update

        <?php for($x=1;$x<=$count;$x++){ ?>
            function openModal<?php echo $x; ?>() {
              document.getElementById('mode<?php echo $x; ?>').style.display = "block";
          }

          function closeModal<?php echo $x; ?>() {
              document.getElementById('mode<?php echo $x; ?>').style.display = "none";

          }

          var slideIndex<?php echo $x; ?> = 1;
        //showSlides1(slideIndex<?php echo $x; ?>);

        function plusSlides<?php echo $x; ?>(n) {
          showSlides<?php echo $x; ?>(slideIndex<?php echo $x; ?> += n);
      }

      function currentSlide<?php echo $x; ?>(n) {
          showSlides<?php echo $x; ?>(slideIndex<?php echo $x; ?> = n);
      }

      function showSlides<?php echo $x; ?>(n) {
          var i;
          var slides<?php echo $x; ?> = document.getElementsByClassName("mySlides<?php echo $x; ?>");
          var dots = document.getElementsByClassName("demo1");
          var captionText = document.getElementById("kik1");
          if (n > slides<?php echo $x; ?>.length) {slideIndex<?php echo $x; ?> = 1}
          if (n < 1) {slideIndex<?php echo $x; ?> = slides<?php echo $x; ?>.length}
          for (i = 0; i < slides<?php echo $x; ?>.length; i++) {
              slides<?php echo $x; ?>[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides<?php echo $x; ?>[slideIndex<?php echo $x; ?>-1].style.display = "block";
          dots[slideIndex<?php echo $x; ?>-1].className += " active";
          captionText.innerHTML = dots[slideIndex<?php echo $x; ?>-1].alt;
      }
      <?php }
      ?>
  </script>

    </html>
