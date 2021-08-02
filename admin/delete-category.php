<?php
  if ($_SESSION['user_role'] == '0'){
    header("location: {$hostname}/admin/post.php");
  }
  include "config.php";

  $catid = $_GET['id'];

  $sql = "DELETE FROM category WHERE category_id = {$catid}";

  if (mysqli_query($conn, $sql)) {
    header("location: {$hostname}/admin/category.php");
  }else {
    echo "<p style='color:red;margin: 10px 0'>Can't delete the user record.</p>";
  }

  // $result = mysqli_query($conn, $sql) or die("Query Unseuccessful.");
  //
  // header("location: {$hostname}/admin/users.php");

  mysqli_close($conn);
?>
