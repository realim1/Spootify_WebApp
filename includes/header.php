<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

//session_destroy();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
}
else{
    header("Location: register.php");
}

?>


<html>
<head>
    <title>Welcome to Spootify</title>

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

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