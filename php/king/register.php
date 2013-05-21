<?php
require_once('config.php');

function register($info) {

  if (empty($info['password']) || $info['password'] != $info['confirm_password']) {
    $_SESSION['error'] = 'Password mismatch!';
    return false;
  }

  if (!mysql_connect(DB_HOST, DB_USER, DB_PASS) || !mysql_select_db(DB_NAME)) {
    $_SESSION['error'] = 'Database Error: ' . mysql_error();
    return false;
  }

  $query = "SELECT * FROM users WHERE username='" . mysql_real_escape_string($info['username']) . "'";
  $result = mysql_query($query);

  if ($result && mysql_num_rows($result) > 0) {
    $_SESSION['error'] = 'Username already exists!';
    return false;
  }

  $query = sprintf("INSERT INTO users(username, password, first_name, last_name, created_at, updated_at)
                    VALUES('%s', '%s', '%s', '%s', now(), now())",
                    mysql_real_escape_string($info['username']),
                    mysql_real_escape_string($info['password']),
                    mysql_real_escape_string($info['first_name']),
                    mysql_real_escape_string($info['last_name'])
                    );
  if (!mysql_query($query) || mysql_affected_rows() < 1) {
    $_SESSION['error'] = 'Database Error: ' . mysql_error();
    return false;
  }

  //-- auto login...
  $user = array(
      'username' => $info['username'],
      'first_name' => $info['first_name'],
      'last_name' => $info['last_name'],
      'display_name' => $info['first_name'] . ' ' . $info['last_name']
      );

  $_SESSION['user'] = $user;
  return true;
}

//==============================================================================

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $info = array(
      'username' => $_POST['username'],
      'password' => $_POST['password'],
      'confirm_password' => $_POST['confirm_password'],
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name']
      );

  register($info);
}

//-- redirect to landing page if already logged in...
if (isset($_SESSION['user'])) {
  header('location: index.php');
  exit();
}
?>

<html>
  <head>
    <title>Register</title>
  </head>
  <body>

  <h1>Registration</h1>

  <?php
  if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    echo "<h2 style='color: red'>$error_message</h2>";

    //-- reset error...
    unset($_SESSION['error']);
  }
  ?>

  <form method='POST' action='register.php'>
  <table border='0' cellpadding='0' cellspacing='4'>
  <tr>
    <td>Username</td>
    <td><input type='text' name='username' value='<?php echo $_POST['username']; ?>'></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type='password' name='password' value='<?php echo $_POST['password']; ?>'></td>
  </tr>
  <tr>
    <td>Confirm Password</td>
    <td><input type='password' name='confirm_password' value='<?php echo $_POST['confirm_password']; ?>'></td>
  </tr>
  <tr>
    <td>First Name</td>
    <td><input type='text' name='first_name' value='<?php echo $_POST['first_name']; ?>'></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type='text' name='last_name' value='<?php echo $_POST['last_name']; ?>'></td>
  </tr>
  <tr>
    <td><a href='login.php'>Login</a></td>
    <td align='right'><input type='submit' name='Submit'></td>
  </tr>
  </table>
  </form>

  </body>
</html>
