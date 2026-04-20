<?php
// Note: Put this file in the XAMPP htdocs folder
// This file provides the information for accessing the database.and connecting to MySQL.
// First, we define the constants:                                                     #1
Define ('DB_USER', 'horatio'); // or whatever userid you created
Define ('DB_PASSWORD', 'Hmsv1ct0ry'); // or whatever password you created
// If no user was created, user ID will be root and Password will be ""
Define ('DB_HOST', 'localhost');
Define ('DB_NAME', 'simpledb');
// Next we assign the database connection to a variable that we will call $dbcon:      #2
try
{
      $dbcon = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      mysqli_set_charset($dbcon, 'utf8'); //                                           #4
      // more code will go here later
}
catch(Exception $e) // We finally handle any problems here                             #3
{
     // print "An Exception occurred. Message: " . $e->getMessage();
     print "The system is busy please try later";
}
catch(Error $e)
{
      //print "An Error occurred. Message: " . $e->getMessage();
      print "The system is busy please try again later.";
}
?>
