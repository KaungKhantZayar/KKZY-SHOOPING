<?php
  session_start();
  session_destroy();

  echo "<script>alert('Are you sure logout')</script>";
  header('Location: login.php');
 ?>
