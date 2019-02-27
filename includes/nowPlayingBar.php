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
        var newPlayList = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlayList[0], newPlayList, false); 
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
            e.preventDefault();
        });
        
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


function toggleRepeat(){
    repeat = !repeat;
    var imageName = repeat ? "repeat_clicked_btn.png" : "repeat_btn.png";
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function toggleShuffle(){
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle_clicked_btn.png" : "shuffle_btn.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

    if(shuffle == true){
        shuffleArray(shufflePlayList);
        currentIndex = shufflePlayList.indexOf(audioElement.currentlyPlaying.id);
    }
    else{
        currentIndex = currentPlayList.indexOf(audioElement.currentlyPlaying.id);
    }
}

function shuffleArray(a){
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

function toggleMute(){
    audioElement.audio.muted = !audioElement.audio.muted
    var imageName = audioElement.audio.muted ? "muted.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}


function setTrack(trackId, newPlayList, play){

    if(newPlayList != currentPlayList){
        currentPlayList = newPlayList;
        shufflePlayList = currentPlayList.slice();
        shuffleArray(shufflePlayList);
    }

    if(shuffle == true){
        currentIndex = shufflePlayList.indexOf(trackId);
    }
    else{
        currentIndex = currentPlayList.indexOf(trackId);
    }

    pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {

        currentIndex = currentPlayList.indexOf(trackId);

        var track = JSON.parse(data);
        $(".trackName span").text(track.title);

        $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
            var artist = JSON.parse(data);
            $(".trackInfo .artistName span").text(artist.name);
            $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artworkPath);
            $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
        });

        audioElement.setTrack(track);
        //playSong();
    
        if(play == true) {
            playSong();
        }
    });
    
}

function playSong(){

    if(audioElement.audio.currentTime == 0){
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }
    else{
        //console.log("Dont Update Time");
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

function nextSong(){

    if(repeat == true){
        audioElement.setTime(0);
        playSong();
        return;
    }

    if(currentIndex == currentPlayList.length - 1){
        currentIndex = 0;
    }
    else{
        currentIndex++;
    }

    var trackToPlay = shuffle ? shufflePlayList[currentIndex] : currentPlayList[currentIndex];
    setTrack(trackToPlay, currentPlayList, true);
}

function prevSong(){
    if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
        audioElement.setTime(0);
    }
    else{
        currentIndex--;
        setTrack(currentPlayList[currentIndex], currentPlayList, true);
    }

}


</script>

<div id = "nowPlayingBarContainer">
    <div id="nowPlayingBar">  

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" src="http://www.bennettig.com/wordpress/wp-content/uploads/2018/07/square-placeholder.jpg" class="albumArtwork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>
                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>
                </div>
            </div>
        </div>


        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button" onclick="toggleShuffle()">
                        <img src="assets/images/icons/shuffle_btn.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous button" onclick = "prevSong()">
                        <img src="assets/images/icons/skip_back_btn.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="assets/images/icons/play_btn.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause_btn.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next button" onclick="nextSong()">
                        <img src="assets/images/icons/skip_next_btn.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat button" onclick="toggleRepeat()">
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
                <button class="controlButton volume" title="Volume button" onclick="toggleMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBackground">
                        <div class="progress"></div>                                    
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>