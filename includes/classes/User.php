<?php

    class User{

        private $con;
        private $username;

        /*---------------------------------------------------------------------------------------------------
        User Constructor takes in:
            MYSQL_connection = $con
            Username = $username
        This function will construct the User object
        -----------------------------------------------------------------------------------------------------*/
        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
            
        }

        /*---------------------------------------------------------------------------------------------------
        getUsername function takes in:
            NOTHING

        This accessor function will return the username of the User as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getUsername(){
            return $this->username;
        }

        /*---------------------------------------------------------------------------------------------------
        getEmail function takes in:
            NOTHING

        This function will retrieve and return the email of the User as a string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getEmail(){
            $query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query);
            return $row['email'];
        }

        /*---------------------------------------------------------------------------------------------------
        getFirstAndLastName function takes in:
            NOTHING

        This function will retrieve the First and Last name of the User and return them as a concatenated 
        string(str)
        -----------------------------------------------------------------------------------------------------*/
        public function getFirstAndLastName(){
            $query = mysqli_query($this->con, "SELECT CONCAT(firstName, ' ', lastName) AS 'name' FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }

    }

?>