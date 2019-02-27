<?php

    class Song {

        private $con;
        private $id;

        private $mysqliData;
        private $title;
        private $artistId;
        private $albumId;
        private $genreId;
        private $duration;
        private $path;

        /*---------------------------------------------------------------------------------------------------
        Song Constructor takes in:
            MYSQL_connection = $con
            songId = $id
        This function will construct the Song object
        -----------------------------------------------------------------------------------------------------*/
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;

            //Query Song table from database using songId
            $songQuery = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
            $this->mysqliData = mysqli_fetch_array($songQuery);
            
            //Set song fields with data from Query.
            $this->title = $this->mysqliData['title'];
            $this->artistId = $this->mysqliData['artist'];
            $this->albumId = $this->mysqliData['album'];
            $this->genreId = $this->mysqliData['genre'];
            $this->duration = $this->mysqliData['duration'];
            $this->path = $this->mysqliData['path'];

        }

        /*---------------------------------------------------------------------------------------------------
        getTitle function takes in:
            NOTHING

        This accessor function will return the name of the song as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getTitle(){
            return $this->title;
        }

        /*---------------------------------------------------------------------------------------------------
        getArtist function takes in:
            NOTHING

        This function will return an Artist object based on the artistId contained in the Song table
        of the database
        -----------------------------------------------------------------------------------------------------*/
        public function getArtist(){
            return new Artist($this->con, $this->artistId);
        }

        /*---------------------------------------------------------------------------------------------------
        getAlbum function takes in:
            NOTHING

        This function will return an Album object based on the albumId contained in the Song table
        of the database
        -----------------------------------------------------------------------------------------------------*/
        public function getAlbum(){
            return new Album($this->con, $this->albumId);
        }
        
        /*---------------------------------------------------------------------------------------------------
        getId function takes in:
            NOTHING

        This accessor function will return the Id of the song as an int
        -----------------------------------------------------------------------------------------------------*/
        public function getId(){
            return $this->id;
        }

        /*---------------------------------------------------------------------------------------------------
        getGenreId function takes in:
            NOTHING

        This accessor function will return the genreId of the song as an int
        -----------------------------------------------------------------------------------------------------*/
        public function getGenreId(){
            return $this->genreId;
        }

        /*---------------------------------------------------------------------------------------------------
        getDuration function takes in:
            NOTHING

        This accessor function will return the Duration of the song as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getDuration(){
            return $this->duration;
        }

        /*---------------------------------------------------------------------------------------------------
        getPath function takes in:
            NOTHING

        This accessor function will return the Path of the song as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getPath(){
            return $this->path;
        }

        /*---------------------------------------------------------------------------------------------------
        getMysqliData function takes in:
            NOTHING

        This function will return the MYSQL_ of the song as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getMysqliData(){
            return $this->mysqliData;
        }

    }

?>