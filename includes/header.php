<?php
    include("includes/config.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");


    //IF userLoggedIn data is in the session array, then create a User object and set user data.
    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
        $username = $userLoggedIn->getUsername();
        echo "<script>
                userLoggedIn = '$username';
            </script>";
    }
    //ELSE fail login and redirect back to login page
    else{
        header("Location: register.php");
    }

?>

<html>
<head>
    <title>Welcome to Spootify</title>

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="shortcut icon" type="image/png" href="assets/images/icons/logo.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="assets/js/script.js"></script>
</head>
<body>
    
    <script>
    /*
        var audioElement = new Audio();
        audioElement.setTrack("assets/music/bensound-actionable.mp3");
        audioElement.audio.play();
    */
    </script>

    <div id="mainContainter">

        <div id="topContainer">
        
            <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">

                <div id="mainContent">