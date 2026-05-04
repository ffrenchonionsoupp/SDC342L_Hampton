<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once(__DIR__ . '/controller/user_controller.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: view/login.php');
    exit();
}

$roleId = $_SESSION['role_id'];

if ($roleId == 1) {
    header('Location: view/dashboard_customer.php');
    exit();
} elseif ($roleId == 2) {
    header('Location: view/dashboard_technician.php');
    exit();
} else {
    header('Location: view/dashboard_admin.php');
    exit();
}