<?php
include 'includes/connection.php';

  $query =$con->query("SELECT fullname,user_id FROM users WHERE fullname LIKE '%".$_GET["fullname"]."%'");
  $result = $query->num_rows;
  if(!empty($result)) {
  ?>
  <ul id="name-type">
  <?php
  while($fetch = mysqli_fetch_array($query)){
    $fullname = $fetch["fullname"];
  ?>
  <li onClick="selectFullname('<?php echo $fullname; ?>',<?php echo $fetch['user_id']?>);"><?php echo $fullname; ?></li>
  <?php } ?>
  </ul>
<?php }  ?>