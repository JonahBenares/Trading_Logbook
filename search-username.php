<?php
include 'includes/connection.php';
if(!empty($_POST["username"])) {
	$query =$con->query("SELECT username FROM users WHERE username LIKE '%".$_POST["username"]."%'");
	$result = $query->num_rows;
	if(!empty($result)) {
	?>
	<ul id="name-user">
	<?php
	while($fetch = mysqli_fetch_array($query)){
		$username = $fetch["username"];
	?>
	<li onClick="selectUsername('<?php echo $username; ?>');"><?php echo $username; ?></li>
	<?php } ?>
	</ul>
<?php 
	} 
} ?>
