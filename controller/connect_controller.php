<?php
    require_once('../model/database.php');

    //controller function to get connection status
    function get_conn_info()
    {
        if (get_db_conn())
        {
            return "Connection successful";
        }
        else
        {
            return "Connection failed";
        }
    }
?>