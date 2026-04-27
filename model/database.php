<?php
class Database {
 //DB connection parameters
 private $host = 'localhost';
 private $dbname = "sdc342L_courseproject";
 private $username = "ecpi_user";
 private $password = "Password1";

 //DB connection and error message
 private $conn;
 private $conn_error = '';

 //constructor - connect to the DB or set an error 
 //message if the connection failed
 function __construct() {
 //turn off error reporing since we're handling errors manually
 mysqli_report(MYSQLI_REPORT_OFF);

 //connect to the database
 $this->conn = mysqli_connect($this->host, $this->username, 
            $this->password, $this->dbname);
 
 //if the connection failed, set the error message
 if ($this->conn === false) {
 $this->conn_error = 
                "Failed to connect to DB: " . mysqli_connect_error();
        }
    }

 function __destruct() {
 if ($this->conn) {
 mysqli_close($this->conn);
        }
    }

 //return the connection; if the connection failed, it will be false
 function getDbConn () {
 return $this->conn;
    }

 function getDbError() {
 return $this->conn_error;
    }

 //functions to get the DB connection parameters
 function getDbHost() {
 return $this->host;
    }

 function getDbName() {
 return $this->dbname;
    }

 function getDbUser() {
 return $this->username;
    }

 function getDbUserPw() {
 return $this->password;
    }
}