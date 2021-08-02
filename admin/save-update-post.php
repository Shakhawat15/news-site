<?php
  include "config.php";

  if (empty($_FILES['new-image']['name'])) {
    $new_name = $_POST['old-image'];
  }else {
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
    $exp = explode('.',$file_name);
    $file_ext = strtolower(end($exp));
    $extentions = ['jpeg','jpg','png'];
    if (in_array($file_ext,$extentions) === false) {
      $errors[] = "This extention file is not allowed, Please choose a jpg or png file.";
    }
    if ($file_size > 2097152) {
      $errors[] = "File size must be 2mb or lower.";
    }
    $new_name = time()."-".basename($file_name);
    $target = "upload/".$new_name;
    $img_name = $new_name;
    if (empty($errors) == true) {
      move_uploaded_file($file_tmp,$target);
    }else {
      print_r($errors);
      die();
    }
  }
  $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
  $title = mysqli_real_escape_string($conn, $_POST['post_title']);
  $postdesc = mysqli_real_escape_string($conn, $_POST['postdesc']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $old_category = mysqli_real_escape_string($conn, $_POST['old-category']);

  $sql = "UPDATE post SET title='{$title}',description='{$postdesc}',category={$category},post_img='{$img_name}'
  WHERE post_id={$post_id};";
  if ($old_category != $category) {
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$old_category};";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category};";
  }

$result = mysqli_multi_query($conn,$sql);



  // $result = mysqli_query($conn, $sql) or die("Query Unseuccessful.");

  if ($result) {
    header("location: {$hostname}/admin/post.php");
  }else {
    echo "<div class='alert alert-danger'>Query Unseuccessful.</div>";
  }

?>
