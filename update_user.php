<?php 
    include 'header.php';
    include 'functions/functions.php';
    $userid=$_SESSION['userid'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        $id = '';
    }
    if(isset($_POST['updateuser'])){
        foreach($_POST as $var=>$value)
            $$var = mysqli_real_escape_string($con,$value);

        $update = $con->query("UPDATE users SET fullname = '$fullname', username = '$username', usertype_id = '$usertype', status = '$status' WHERE user_id = '$id'");
        if($update){
            echo "<script>alert('Successfully Updated!'); window.opener.location.reload(); window.close();</script>";
        }
    }
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
                                        <strong>Update User</strong>
                                    </h2>                                    
                                </div>
                                <div class="card-content table-responsive">
                                    <?php 
                                        $sql = mysqli_query($con,"SELECT * FROM users WHERE user_id = '$id'");
                                        $row = mysqli_fetch_array($sql);
                                    ?>
                                    <form method="POST">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Fullname</label>
                                                <input type="text" name = "fullname" class="form-control" style="width:100%" value = "<?php echo $row['fullname'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Username</label>
                                                <input type="text" name = "username" class="form-control" style="width:100%" value = "<?php echo $row['username'];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Usertype</label>
                                                <select class="form-control" id = "usertype" name = "usertype" required>
                                                    <?php                                        
                                                        $sql1 = mysqli_query($con,"SELECT * FROM usertype ORDER BY usertype_name ASC");
                                                        while($row1 = mysqli_fetch_array($sql1)) {
                                                    ?>
                                                    <option value = "<?php echo $row1['usertype_id']?>" <?php echo (($row1['usertype_id'] == $row['usertype_id']) ? ' selected' : ''); ?>><?php echo $row1["usertype_name"]?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Status</label>
                                                <select class="form-control" id = "status" name = "status" required>
                                                    <option value = "Active"  <?php echo (($row['status'] == 'Active') ? ' selected' : ''); ?>>Active</option>
                                                    <option value = "Inactive" <?php echo (($row['status'] == 'Inactive') ? ' selected' : ''); ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <center>
                                            <input type="submit" class="btn btn-info" value = "Save Changes" name = "updateuser">
                                        </center>
                                        <input type='hidden' name='userid' value="<?php echo $userid; ?>">
                                        <input type='hidden' name='id' value="<?php echo $id; ?>">
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
