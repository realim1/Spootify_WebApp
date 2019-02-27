<?php

class Playlist {

    private $con;
    private $id;
    private $name;
    private $owner;

    /*---------------------------------------------------------------------------------------------------
    Playlist Constructor takes in:
        MYSQL_connection = $con
        playlistId OR playlistQuery = $data
    This function will construct the Playlist object
    -----------------------------------------------------------------------------------------------------*/
    public function __construct($con, $data){

        //IF query array was not passed in(playlistId was passed instead), then create the query
        if(!is_array($data)){
            $query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
            $data = mysqli_fetch_array($query);
        }
        //Set playlist fields with data from Query.
        $this->con = $con;
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->owner = $data['owner'];
    }

    /*---------------------------------------------------------------------------------------------------
    getId function takes in:
        NOTHING

    This accessor function will return the id of the playlist as an int
    -----------------------------------------------------------------------------------------------------*/
    public function getId(){
        return $this->id;
    }

    /*---------------------------------------------------------------------------------------------------
    getName function takes in:
        NOTHING

    This accessor function will return the name of the playlist as a string(str)
    -----------------------------------------------------------------------------------------------------*/
    public function getName(){
        return $this->name;
    }

    /*---------------------------------------------------------------------------------------------------
    getOwner function takes in:
        NOTHING

    This accessor function will return the username of the playlist as a string(str)
    -----------------------------------------------------------------------------------------------------*/
    public function getOwner(){
        return $this->owner;
    }

    /*---------------------------------------------------------------------------------------------------
    getNumberOfSongs function takes in:
        NOTHING

    This function will return the number of songs within the album as an int.
    -----------------------------------------------------------------------------------------------------*/
    public function getNumberOfSongs(){
        $query = mysqli_query($this->con, "SELECT songId FROM playlistsongs WHERE playlistId='$this->id'");
        return mysqli_num_rows($query);
    }

    /*---------------------------------------------------------------------------------------------------
    getSongIds function takes in:
        NOTHING

    This function will return the list of songIds within the playlist as an array of ints. List will be sorted
    base on the playlistOrder.
    -----------------------------------------------------------------------------------------------------*/
    public function getSongIds(){

        $query = mysqli_query($this->con, "SELECT songId FROM playlistsongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");

        $songArray = array();

        while($row = mysqli_fetch_array($query)){
            array_push($songArray, $row['songId']);
        }

        return $songArray;

    }

    /*---------------------------------------------------------------------------------------------------
    getPlaylistsDropdown function takes in:
        MYSQL_connection = $con
        Username = $username

    This function creates the drop down menu when the 'Add to playlist' field is clicked. It will
    query the available playlists of the user and display their playlists on the drop down menu.
    -----------------------------------------------------------------------------------------------------*/
    public static function getPlaylistsDropdown($con, $username){
        $dropdown = '<select class="item playlist">
                        <option value="">Add to playlist</option>';
        
        $query = mysqli_query($con, "SELECT id, name FROM playlists WHERE owner='$username'");
        while($row = mysqli_fetch_array($query)){
            $id = $row['id'];
            $name = $row['name'];

            $dropdown = $dropdown . "<option value='$id'>$name</option>";
        }

        return $dropdown . "</select>";
    }

}

?>