<?php
    class Account{

        private $errorArray;
        private $con;

        //Account Constructor
        public function __construct($con){
            //Creates empty array for errorArray
            $this->errorArray = array();

            //Sets connection to MYSQL database
            $this->con = $con;
        }

        /*---------------------------------------------------------------------------------------------------
        Login function takes in:
            Username = $un
            Password = $pw
        This function will attempt to login by checking that the username and password exist on the server.
        -----------------------------------------------------------------------------------------------------*/
        public function login($un, $pw){
            $encryptedPw = md5($pw);

            $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND userPassword='$encryptedPw'");

            if(mysqli_num_rows($query) == 1){
                return true;
            }
            else{
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
            
        }

        /*---------------------------------------------------------------------------------------------------
        Register function takes in:
            Username = $un
            FirstName = $fn
            LastName = $ln
            Email = $em
            confirmEmail = $em2
            Password = $pw
            confirmPassword = $pw2

        This function will call other functions to validate each field and report an error based on the field.
        -----------------------------------------------------------------------------------------------------*/
        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            }
            else{
                return false;
            }
        }


        /*---------------------------------------------------------------------------------------------------
        insertUserDetails function takes in:
            Username = $un
            FirstName = $fn
            LastName = $ln
            Email = $em
            Password = $pw

        This function will encrypt the password using the MD5 hash function, set the default profile picture,
        set the date, and the store the user's information into the MYSQL database.
        -----------------------------------------------------------------------------------------------------*/
        private function insertUserDetails($un, $fn, $ln, $em, $pw){
            $encryptedPw = md5($pw);
            $profilePic = "assets/images/profile-pics/default_user_icon.png";
            $date = date("Y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

            return $result;
        }   

        /*---------------------------------------------------------------------------------------------------
        getError function takes in an errorMsg string and checks if the error occured and prints the errorMsg
        to the web page.
        -----------------------------------------------------------------------------------------------------*/
        public function getError($errorMsg){
            if(!in_array($errorMsg, $this->errorArray)){
                $errorMsg = "";
            }
            return "<span class='errorMessage'>$errorMsg</span>";
        }

        /*---------------------------------------------------------------------------------------------------
        validateUsername function takes in a Username and checks if its valid
            - Username must have length between 5 and 25 characters
            - Username does not already exist in the database
        -----------------------------------------------------------------------------------------------------*/
        private function validateUsername($un){
            //Username length must be between 5-25 characters
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameLengthErrorMsg);
                return;
            }

            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        }

        /*---------------------------------------------------------------------------------------------------
        validateFirstName function takes in a FirstName and checks if its valid
            - FirstName must have length between 2 and 25 characters
        -----------------------------------------------------------------------------------------------------*/
        private function validateFirstName($fn){
            //FirstName length must be between 2-25 characters
            if(strlen($fn) > 25 || strlen($fn) < 2){
                array_push($this->errorArray, Constants::$firstNameLengthErrorMsg);
                return;
            }
        }


        /*---------------------------------------------------------------------------------------------------
        validateLastName function takes in a LastName and checks if its valid
            - LastName must have length between 2 and 25 characters
        -----------------------------------------------------------------------------------------------------*/
        private function validateLastName($ln){
            //LastName length must be between 2-25 characters
            if(strlen($ln) > 25 || strlen($ln) < 2){
                array_push($this->errorArray, Constants::$lastNameLengthErrorMsg);
                return;
            }
        }

        /*---------------------------------------------------------------------------------------------------
        validateEmails function takes in a Email and confirmEmail and checks if its valid
            - Email and confirmEmail must be the same
            - Email must be in valid Email format
            - Email does not already exist in the database
        -----------------------------------------------------------------------------------------------------*/
        private function validateEmails($em, $em2){
            //Checks if the email and confirmEmail are the same
            if($em != $em2){
                array_push($this->errorArray, Constants::$emailsDoNotMatchErrorMsg);
                return;
            }
            //Checks if the email is in email format
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailFormatErrorMsg);
                return;
            }

            //Check that email hasn't already been used.
            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }

        /*---------------------------------------------------------------------------------------------------
        validatePasswords function takes in a Password and confirmPassword and checks if its valid
            - Password and confirmPassword must be the same
            - Password must only contain numbers and letters
            - Password must have length between 5-30 characters
        -----------------------------------------------------------------------------------------------------*/
        private function validatePasswords($pw, $pw2){
            //Checks if the Password and confirmPassword and the same
            if($pw != $pw2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatchErrorMsg);
                return;
            }

            //Checks if the Password only contains numbers and letters
            if(preg_match('/[^A-Za-z0-9]/', $pw)){
                array_push($this->errorArray, Constants::$passwordsNotAlphanumericErrorMsg);
                return;
            }

            //Checks if Password length is between 5-30 characters
            if(strlen($pw) > 30 || strlen($pw) < 5){
                array_push($this->errorArray, Constants::$passwordsLengthErrorMsg);
                return;
            }
        }

    }
?>