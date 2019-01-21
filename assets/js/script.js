var currentPlayList = [];
var audioElement;


function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    //function of class Audio
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


}