<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once(__DIR__ . '/../controller/user.php');
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../util/security.php');

$error = '';
$login_msg = '';

Security::checkHTTPS();
if (isset($_POST['username']) && isset($_POST['password'])) {

  $user = UserController::login($_POST['username'], $_POST['password']);

  if ($user) {
      $roleId = $user->getRoleId();

      if ($roleId == 1) {
          header("Location: dashboard_customer.php");
          exit();
      } elseif ($roleId == 2) {
          header("Location: dashboard_technician.php");
          exit();
      } elseif ($roleId == 3) {
          header("Location: dashboard_admin.php");
          exit();
      }
  } else {
      $login_msg = 'Failed Authentication - try again.';
  }
}

?>
<html>
<head>
    <title>Complaint System Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Complaint Management System</h1>
<h2>Login</h2>
<form method="POST">
    <p>Username:
        <input type="text" name="username">
    </p>
    <p>Password:
        <input type="password" name="password">
    </p>
    <p class="error"><?php echo $error; ?></p>
    <p><input type="submit" name="login" value="Login"></p>

    <p><a href="register.php">Create an account</a></p>
</form>
<h2><?php echo $login_msg; ?></h2>
</body>
</html>
