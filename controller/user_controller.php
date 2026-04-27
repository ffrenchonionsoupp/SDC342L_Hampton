// login
// logout
// getUserById
// getTechnicians
// getCustomers
<?php
require_once(__DIR__ . '/../model/user_db.php');

class UserController {

    public static function login($username, $password) {
        $user = UserDB::getUserByUsername($username);

        if ($user && password_verify($password, $user->getPasswordHash())) {
            $_SESSION['user_id'] = $user->getUserId();
            $_SESSION['role_id'] = $user->getRoleId();
            $_SESSION['full_name'] = $user->getFullName();
            return $user;
        }

        return false;
    }

    public static function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: view/login.php');
            exit();
        }
    }

    public static function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public static function getCurrentRoleId() {
        return $_SESSION['role_id'] ?? null;
    }
    public static function register($username, $password, $fullName, $email, $roleId) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return UserDB::registerUser($username, $hash, $fullName, $email, $roleId);
    }

}
