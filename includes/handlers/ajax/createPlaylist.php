<?php
    include("../../config.php");

    if(isset($_POST['name']) && isset($_POST['username'])){

        if($_POST['name'] == ""){
            echo "Please enter a name for your playlist";
            exit();
        }

        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d");
        
        $query = mysqli_query($con, "INSERT playlists VALUES('', '$name', '$username', '$date')");

    }
    else{
        echo "Name or username parameters not passed into file";
    }

?>