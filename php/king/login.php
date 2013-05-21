<?php
require_once('config.php');

function authenticate($username, $password) {

  if (!mysql_connect(DB_HOST, DB_USER, DB_PASS) || !mysql_select_db(DB_NAME)) {
    $_SESSION['error'] = 'Database Error: ' . mysql_error();
    return false;
  }

  $query = "SELECT * FROM users WHERE username='" . mysql_real_escape_string($username)
         . "' AND password='". mysql_real_escape_string($password) . "'";
  $result = mysql_query($query);

  if ($result && mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    $user = array(
        'username' => $row['username'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'display_name' => $row['first_name'] . ' ' . $row['last_name']
        );

    $_SESSION['user'] = $user;
  } else {
    $_SESSION['error'] = 'Invalid username or password!';
    return false;
  }

  return true;
}

//==============================================================================

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  authenticate($_POST['username'], $_POST['password']);
}

//-- redirect to landing page if already logged in...
if (isset($_SESSION['user'])) {
  header('location: index.php');
  exit();
}
?>

<html>
  <head>
    <title>Login</title>
  </head>
  <body>

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
      <input type='text' name='username' placeholder='Username' value='<?php echo $_POST['username']; ?>'>
      <input type='password' name='password' placeholder='Password' value='<?php echo $_POST['password']; ?>'>
      <input type='submit' value='Login'>
    </form>

    <div>
      <a href='register.php'>Register</a>
    </div>

  </body>
</html>
