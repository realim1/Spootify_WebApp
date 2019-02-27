<?php

    class Album {

        private $con;
        private $id;

        private $title;
        private $artistId;
        private $genreId;
        private $artworkPath;

        /*---------------------------------------------------------------------------------------------------
        Album Constructor takes in:
            MYSQL_connection = $con
            albumId = $id
        This function will construct the Album object
        -----------------------------------------------------------------------------------------------------*/
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;

            //Query album table from database using albumId
            $albumQuery = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
            $album = mysqli_fetch_array($albumQuery);

            //Set album fields with data from Query.
            $this->title = $album['title'];
            $this->artistId = $album['artist'];
            $this->genreId = $album['genre'];
            $this->artworkPath = $album['artworkPath'];
        }

        /*---------------------------------------------------------------------------------------------------
        getTitle function takes in:
            NOTHING

        This accessor function will return the name of the album as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getTitle(){
            return $this->title;
        }

        /*---------------------------------------------------------------------------------------------------
        getArtist function takes in:
            NOTHING

        This function will return an Artist object based on the artistId contained in the Album table
        of the database
        -----------------------------------------------------------------------------------------------------*/
        public function getArtist(){
            return new Artist($this->con, $this->artistId);
        }

        /*---------------------------------------------------------------------------------------------------
        getGenreId function takes in:
            NOTHING

        This accessor function will return the genreId of the album as an int.
        -----------------------------------------------------------------------------------------------------*/
        public function getGenreId(){
            return $this->genreId;
        }

        /*---------------------------------------------------------------------------------------------------
        getArtworkPath function takes in:
            NOTHING

        This accessor function will return the artworkPath of the album as a string.
        -----------------------------------------------------------------------------------------------------*/
        public function getArtworkPath(){
            return $this->artworkPath;
        }

        /*---------------------------------------------------------------------------------------------------
        getNumberOfSongs function takes in:
            NOTHING

        This function will return the number of songs within the album as an int.
        -----------------------------------------------------------------------------------------------------*/
        public function getNumberOfSongs(){
            $query = mysqli_query($this->con, "SELECT * FROM songs WHERE album='$this->id'");
            return mysqli_num_rows($query);
        }

        /*---------------------------------------------------------------------------------------------------
        getSongIds function takes in:
            NOTHING

        This function will return the list of songIds within the album as an array of ints. List will be sorted
        base on the albumOrder.
        -----------------------------------------------------------------------------------------------------*/
        public function getSongIds(){

            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");

            $songArray = array();

            while($row = mysqli_fetch_array($query)){
                array_push($songArray, $row['id']);
            }

            return $songArray;

        }

    }

?>