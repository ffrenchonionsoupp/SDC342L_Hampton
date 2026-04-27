<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../model/user_db.php');

$errors = [
    'username' => '',
    'password' => '',
    'full_name' => '',
    'email' => '',
    'role' => ''
];

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $roleId = $_POST['role_id'];

    $valid = true;

    // USERNAME
    if ($username === '') {
        $errors['username'] = "Required";
        $valid = false;
    } elseif (UserDB::usernameExists($username)) {
        $errors['username'] = "Username already taken";
        $valid = false;
    }

    // PASSWORD
    if ($password === '') {
        $errors['password'] = "Required";
        $valid = false;
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Must be at least 6 characters";
        $valid = false;
    }

    // FULL NAME
    if ($fullName === '') {
        $errors['full_name'] = "Required";
        $valid = false;
    }

    // EMAIL
    if ($email === '') {
        $errors['email'] = "Required";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
        $valid = false;
    } elseif (UserDB::emailExists($email)) {
        $errors['email'] = "Email already registered";
        $valid = false;
    }

    // ROLE
    if ($roleId === '') {
        $errors['role'] = "Required";
        $valid = false;
    }

    if ($valid) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        UserDB::registerUser($username, $hash, $fullName, $email, $roleId);

        // Auto-login
        $user = UserDB::getUserByUsername($username);
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['role_id'] = $user->getRoleId();
        $_SESSION['full_name'] = $user->getFullName();

        header("Location: ../index.php");
        exit();
    }
}
?>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Create Account</h1>

<form method="POST">

    <p>Username:
        <input type="text" name="username"
               value="<?php echo $_POST['username'] ?? ''; ?>">
        <span class="error"><?php echo $errors['username']; ?></span>
    </p>

    <p>Password:
        <input type="password" name="password">
        <span class="error"><?php echo $errors['password']; ?></span>
    </p>

    <p>Full Name:
        <input type="text" name="full_name"
               value="<?php echo $_POST['full_name'] ?? ''; ?>">
        <span class="error"><?php echo $errors['full_name']; ?></span>
    </p>

    <p>Email:
        <input type="text" name="email"
               value="<?php echo $_POST['email'] ?? ''; ?>">
        <span class="error"><?php echo $errors['email']; ?></span>
    </p>

    <p>Role:
        <select name="role_id">
            <option value="">-- Select Role --</option>
            <option value="1">Customer</option>
            <option value="2">Technician</option>
            <option value="3">Admin</option>
        </select>
        <span class="error"><?php echo $errors['role']; ?></span>
    </p>

    <p>
        <input type="submit" name="register" value="Register">
        <a href="login.php">Cancel</a>
    </p>

</form>

</body>
</html>
