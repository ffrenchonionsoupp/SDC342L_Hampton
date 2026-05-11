<?php
require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/../controller/user.php');

class UsersDB {

    public static function getUserByUsername($username) {
        $db = new Database();
        $conn = $db->getDbConn();

        $username = $conn->real_escape_string($username);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        if ($row = $result->fetch_assoc()) {
            $user = new User(
                $row['username'],
                $row['password_hash'],
                $row['full_name'],
                $row['email'],
                $row['role_id']
            );
            $user->setUserId($row['user_id']);
            return $user;
        }

        return false;
    }
    public static function getUsersByRole($roleId) {

        $db = new Database();
        $conn = $db->getDbConn();
    
        $query = "
            SELECT *
            FROM users
            WHERE role_id = '$roleId'
            ORDER BY full_name
        ";
    
        $result = $conn->query($query);
    
        $rows = [];
    
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    
        return $rows;
    }
    //function to get a user by their e-mail address
    public static function getUserByEMail($email) {
        //get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            //create the query string
            $query = "SELECT * FROM users
            WHERE users.email = '$email'";

            //execute the query - returns false if
            //no such email found
            $result = $dbConn->query($query);
            return $result->fetch_assoc();
                    } else {
            return false;
                    }
        }

    public static function getTechnicians() {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT * FROM users u JOIN roles r ON u.role_id = r.role_id
                  WHERE r.role_name = 'technician'";
        $result = $conn->query($query);

        $techs = [];
        while ($row = $result->fetch_assoc()) {
            $user = new User(
                $row['username'],
                $row['password_hash'],
                $row['full_name'],
                $row['email'],
                $row['role_id']
            );
            $user->setUserId($row['user_id']);
            $techs[] = $user;
        }

        return $techs;
    }
    public static function usernameExists($username) {
        $db = new Database();
        $conn = $db->getDbConn();

        $username = $conn->real_escape_string($username);
        $query = "SELECT user_id FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        return $result->num_rows > 0;
    }

    public static function emailExists($email) {
        $db = new Database();
        $conn = $db->getDbConn();

        $email = $conn->real_escape_string($email);
        $query = "SELECT user_id FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        return $result->num_rows > 0;
    }

    public static function registerUser($username, $hash, $fullName, $email, $roleId) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "INSERT INTO users (username, password_hash, full_name, email, role_id)
                VALUES (
                    '{$conn->real_escape_string($username)}',
                    '$hash',
                    '{$conn->real_escape_string($fullName)}',
                    '{$conn->real_escape_string($email)}',
                    '$roleId'
                )";

        return $conn->query($query);
    }

}
