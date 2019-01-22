var currentPlayList = [];
var audioElement;
var mouseDown = false;
var savedVolume;


function formatTime(seconds) {

    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;

    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');


    //EventListeners of class Audio
    this.audio.addEventListener("canplay", function(){
        //'this' refers to the object that the event was called on
        // equvialent to this.audio.duration
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
        updateVolumeProgressBar(this);
    });

    this.audio.addEventListener("timeupdate", function(){
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });

    //Functions of class Audio
    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.mute = function(){
        savedVolume = this.audio.volume;
        this.audio.volume = 0;
    }

    this.unmute = function(){
        this.audio.volume = savedVolume;
    }


    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }

}