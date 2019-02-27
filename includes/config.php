<?php
    //Start Output Buffer and session for storing userdata.
    ob_start();
    session_start();

    
    $timezone = date_default_timezone_set("America/Los_Angeles");

    //Create MYSQL_connection
    $con = mysqli_connect("localhost", "root", "", "spootify");

    //If there is a MYSQL connection issue, then display error message
    if(mysqli_connect_errno()){
        echo "Failed to connect: " . mysqli_connect_errno();
    }

?>