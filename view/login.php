<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');

$error = '';

if (isset($_POST['login'])) {
    $user = UserController::login($_POST['username'], $_POST['password']);

    if ($user) {
        header('Location: ../index.php');
        exit();
    } else {
        $error = "Invalid username or password.";
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
</body>
</html>
