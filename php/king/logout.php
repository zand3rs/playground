<?php
  session_start();
  unset($_SESSION['user']);
  unset($_SESSION['error']);

  header('location: index.php');
?>
