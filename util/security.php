<?php
//helper functions for dealing with security

class Security {
 public static function checkHTTPS() {
 //if not HTTPS, post a message and exit
 if (!isset($_SERVER['HTTPS']) 
            || $_SERVER['HTTPS'] != 'on') 
        {
 //for demonstration - normally just
 //redirect to your https:// url
 echo "<h1>HTTPS is Required!</h1>";
 echo "<h2>Please reload in HTTPS to proceed.</h1>";
 exit();
        }
    }

 //perform any needed clean-up for logging out
 public static function logout() {
    // Clear all session variables
    $_SESSION = [];

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session itself
    session_destroy();

    // Redirect with message
    session_start();
    $_SESSION['logout_msg'] = 'Successfully logged out.';
    header('Location: ../index.php');
    exit();
}


public static function checkAuthority($requiredRole) {

    if (!isset($_SESSION['role_id'])) {
        header("Location: login.php");
        exit();
    }

    $roleId = $_SESSION['role_id'];

    // Map role names to IDs
    $roles = [
        'customer' => 1,
        'technician' => 2,
        'admin' => 3
    ];

    if (!isset($roles[$requiredRole])) {
        die("Invalid role check");
    }

    if ($roleId != $roles[$requiredRole]) {
        $_SESSION['logout_msg'] = 'Current login unauthorized for this page.';
        header("Location: ../index.php");
        exit();
    }
}
    
}