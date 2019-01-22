<?php

    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)){
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);

?>

<script>

    $(document).ready(function(){
        currentPlayList = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(currentPlayList[0], currentPlayList, false); 
        updateVolumeProgressBar(audioElement.audio);
        
        $(".playbackBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mouseup(function(e){
            timeFromOffset(e, this);
        });

        $(".playbackBar .progressBar").mousemove(function(e){
            if(mouseDown == true){
                timeFromOffset(e, this);
            }
        });


        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mouseup(function(e){
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1){
                audioElement.audio.volume = percentage;
                if(percentage == 0){
                    $(".controlButton.volume").hide();
                    $(".controlButton.novolume").show();
                }
                else{
                    $(".controlButton.novolume").hide();
                    $(".controlButton.volume").show();
                }
            }
        });

        $(".volumeBar .progressBar").mousemove(function(e){
            if(mouseDown == true){
                var percentage = e.offsetX / $(this).width();
                if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                    if(percentage == 0){
                        $(".controlButton.volume").hide();
                        $(".controlButton.novolume").show();
                    }
                    else{
                        $(".controlButton.novolume").hide();
                        $(".controlButton.volume").show();
                    }
                }
            }
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });

    });

function timeFromOffset(mouse, progressBar){
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);

    audioElement.setTime(seconds);
}

function setTrack(trackId, newPlayList, play){

    $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {

        var track = JSON.parse(data);
        $(".trackName span").text(track.title);

        $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
            var artist = JSON.parse(data);
            $(".artistName span").text(artist.name);
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
            var album = JSON.parse(data);
            $(".albumLink img").attr("src", album.artworkPath);
        });

        audioElement.setTrack(track);
    });
    
    if(play == true) {
        audioElement.play();
    }
}

function playSong(){

    if(audioElement.audio.currentTime == 0){
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }
    else{
        console.log("Dont Update Time");
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong(){
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
}

function muteSong(){
    $(".controlButton.volume").hide();
    $(".controlButton.novolume").show();
    audioElement.mute();
}

function unmuteSong(){
    $(".controlButton.novolume").hide();
    $(".controlButton.volume").show();
    audioElement.unmute();
}


</script>


<div id="nowPlayingBar">  

    <div id="nowPlayingLeft">
        <div class="content">
            <span class="albumLink">
                <img src="http://www.bennettig.com/wordpress/wp-content/uploads/2018/07/square-placeholder.jpg" class="albumArtwork">
            </span>

            <div class="trackInfo">
                <span class="trackName">
                    <span></span>
                </span>
                <span class="artistName">
                    <span></span>
                </span>
            </div>
        </div>
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

                <button class="controlButton play" title="Play button" onclick="playSong()">
                    <img src="assets/images/icons/play_btn.png" alt="Play">
                </button>

                <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
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
        <div class="volumeBar">
            <button class="controlButton volume" title="Volume button" onclick="muteSong()">
                <img src="assets/images/icons/volume.png" alt="Volume">
            </button>

            <button class="controlButton novolume" title="Volume button" style="display: none;" onclick="unmuteSong()">
                <img src="assets/images/icons/muted.png" alt="Volume">
            </button>

            <div class="progressBar">
                <div class="progressBarBackground">
                    <div class="progress"></div>                                    
                </div>
            </div>
        </div>
    </div>
    
</div>