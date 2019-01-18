<?php
include("includes/config.php");

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
</head>
<body>
    
    <div id = "nowPlayingBarContainer">
        <div id="nowPlayingBar">
            <div id="nowPlayingLeft">

            </div>

            <div id="nowPlayingCenter">

                <div class="content playerControls">

                    <div class="buttons">
                        <button class="controlButton shuffle" title="Shuffle button">
                            <img src="assets/images/icons/shuffle_btn.png" alt="Shuffle">
                        </button>

                        <button class="controlButton previous" title="Previous button">
                            <img src="assets/images/icons/skip_back_btn.png" alt="Previous">
                        </button>

                        <button class="controlButton play" title="Play button">
                            <img src="assets/images/icons/play_btn.png" alt="Play">
                        </button>

                        <button class="controlButton pause" title="Pause button" style="display: none;">
                            <img src="assets/images/icons/pause_btn.png" alt="Pause">
                        </button>

                        <button class="controlButton next" title="Next button">
                            <img src="assets/images/icons/skip_next_btn.png" alt="Next">
                        </button>

                        <button class="controlButton repeat" title="Repeat button">
                            <img src="assets/images/icons/repeat_btn.png" alt="Repeat">
                        </button>
                    </div>

                    <div class="playbackBar">

                        <span class="progressTime current">0.00</span>

                        <div class="progressBar">
                            <div class="progressBarBackground">
                                <div class="progress"></div>                                    
                            </div>
                        </div>

                        <span class="progressTime remaining">0.00</span>

                    </div>

                </div>

            </div>

            <div id="nowPlayingRight">

            </div>
        </div>
    </div>

</body>
</html>