<html>
  <head>
    <title>Index</title>
  </head>
  <body>

  <?php
  session_start();
  if (isset($_SESSION['user'])):
    $user = $_SESSION['user'];
  ?>

    <h1>Hello <?php echo $user['display_name']; ?>!</h1>
    <div>
      <a href='logout.php'>Logout</a>
    </div>

  <?php else: ?>

    <h1>Welcome!</h1>

    <?php
    if (isset($_SESSION['error'])) {
      $error_message = $_SESSION['error'];
      echo "<h2 style='color: red'>$error_message</h2>";

      //-- reset error...
      unset($_SESSION['error']);
    }
    ?>

    <form method='POST' action='login.php'>
      <input type='text' name='username' placeholder='Username'>
      <input type='password' name='password' placeholder='Password'>
      <input type='submit' value='Login'>
    </form>

    <div>
      <a href='register.php'>Register</a>
    </div>

  <?php endif; ?>

  </body>
</html>
