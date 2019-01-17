<?php
    class Constants{

        //Error messages for register
        public static $passwordsDoNotMatchErrorMsg = "Your passwords don't match";
        public static $passwordsNotAlphanumericErrorMsg = "Your passwords can only contain numbers and letters";
        public static $passwordsLengthErrorMsg = "Your password must be between 5 and 30 characters";
        public static $emailFormatErrorMsg = "Email is invalid";
        public static $emailsDoNotMatchErrorMsg = "Your emails don't match";
        public static $emailTaken = "This email is already being used";
        public static $lastNameLengthErrorMsg = "Your last name must be between 2 and 25 characters";
        public static $firstNameLengthErrorMsg = "Your first name must be between 2 and 25 characters";
        public static $usernameLengthErrorMsg = "Your username must be between 5 and 25 characters";
        public static $usernameTaken = "This username already exists";

        //Error messages for login
        public static $loginFailed = "Your username or password was incorrect";
        
    }
?>