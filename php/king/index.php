<?php
session_start();

//-- redirect to login page if not logged in yet...
if (!isset($_SESSION['user'])) {
  header('location: login.php');
  exit();
}

$user = $_SESSION['user'];
?>

<html>
  <head>
    <title>Home</title>
  </head>
  <body>

    <h1>Hello <?php echo $user['display_name']; ?>!</h1>
    <div>
      <a href='logout.php'>Logout</a>
    </div>

  </body>
</html>
