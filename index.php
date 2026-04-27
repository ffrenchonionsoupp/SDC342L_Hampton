<?php
session_start();
require_once(__DIR__ . '/controller/user_controller.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: view/login.php');
    exit();
}

$roleId = UserController::getCurrentRoleId();

if ($roleId == 1) {          // assume 1 = customer
    header('Location: view/dashboard_customer.php');
} elseif ($roleId == 2) {    // technician
    header('Location: view/dashboard_technician.php');
} else {                     // admin
    header('Location: view/dashboard_admin.php');
}
exit();
