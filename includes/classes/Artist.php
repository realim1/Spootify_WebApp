<?php

    class Artist {

        private $con;
        private $id;

        /*---------------------------------------------------------------------------------------------------
        Artist Constructor takes in:
            MYSQL_connection = $con
            artistId = $id
        This function will construct the Account object
        -----------------------------------------------------------------------------------------------------*/
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
        }

        /*---------------------------------------------------------------------------------------------------
        getName function takes in:
            NOTHING

        This function will return the name of the artist as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getName(){
            $artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
            $artist = mysqli_fetch_array($artistQuery);

            return $artist['name'];
        }

        /*---------------------------------------------------------------------------------------------------
        getGenreId function takes in:
            NOTHING

        This accessor function will return the Id of the Artist as an int.
        -----------------------------------------------------------------------------------------------------*/
        public function getId(){
            return $this->id;
        }

        /*---------------------------------------------------------------------------------------------------
        getSongIds function takes in:
            NOTHING

        This function will return the list of songIds from the album as an array of ints. List will be sorted
        from most played song to least played song.
        -----------------------------------------------------------------------------------------------------*/
        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");

            $songArray = array();

            while($row = mysqli_fetch_array($query)){
                array_push($songArray, $row['id']);
            }

            return $songArray;
        }

    }

?>