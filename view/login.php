<?php
session_start();
require_once(__DIR__ . '/../controller/user.php');
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../util/security.php');

$error = '';

Security::checkHTTPS();
//set the message related to login/logout functionality
$login_msg = isset($_SESSION['logout_msg']) ? 
 $_SESSION['logout_msg'] : '';

if (isset($_POST['email']) & isset($_POST['pw'])) {
 //login and password fields were set
 $roleId = UserController::validUser(
 $_POST['email'], $_POST['pw']);

 if ($roleId === '1') {
 $_SESSION['admin'] = false;
 $_SESSION['user'] = true;
 $_SESSION['tech'] = false;
 header("Location: view/dashboard_customer.php");
    } else if ($roleId === '2') {
 $_SESSION['admin'] = false;
 $_SESSION['user'] = false;
 $_SESSION['tech'] = true;
 header("Location: view/dashboard_technician.php");
   } else if ($roleId === '3') {
 $_SESSION['admin'] = true;
 $_SESSION['user'] = false;
 $_SESSION['tech'] = false;
 header("Location: view/dashboard_admin.php");
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
