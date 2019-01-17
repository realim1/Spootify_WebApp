
<?php

    function cleanupFormUsername($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);

        return $inputText;
    }

    function cleanupFormString($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $firstName = ucfirst(strtolower($inputText));
        
        return $inputText;
    }

    function cleanupFormPassword($inputText){
        $inputText = strip_tags($inputText);
        
        return $inputText;
    }


    if(isset($_POST['registerButton'])){
        //register button was pressed

        //Cleanup the form data
        $username = cleanupFormUsername($_POST['username']);
        $firstName = cleanupFormString($_POST['firstName']);  
        $lastName = cleanupFormString($_POST['lastName']);
        $email = cleanupFormString($_POST['email']);
        $confirmEmail = cleanupFormString($_POST['confirmEmail']);
        $password = cleanupFormPassword($_POST['password']);
        $confirmPassword = cleanupFormPassword($_POST['confirmPassword']);

        $isSuccessful = $account->register($username, $firstName, $lastName, $email, $confirmEmail, $password, $confirmPassword);

        if($isSuccessful == true){
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }
    }

?>