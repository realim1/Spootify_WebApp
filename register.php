<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    //Function used to save the fields(except password) when register form is declined.
    function rememberInputValue($inputText){
        if(isset($_POST[$inputText])){
            echo $_POST[$inputText];
        }
    }
?>



<html>
<head>
    <title>Register</title>

    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <link rel="shortcut icon" type="image/png" href="assets/images/icons/logo.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>


<body>

    <?php
        //IF the register button is pressed("SIGN UP" button) then stay on register info form
        if(isset($_POST['registerButton'])){
            echo '<script>
                    $(document).ready(function(){
                        $("#loginForm").hide();
                        $("#registerForm").show();
                    });
                 </script>';
        }
        //ELSE always load with the login info form
        else{
            echo '<script>
                    $(document).ready(function(){
                        $("#loginForm").show();
                        $("#registerForm").hide();
                    });
                 </script>';
        }
    
    ?>

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <!-----------------------------LOGIN FORM START----------------------------->
                <form id="loginForm" action="register.php" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. Peter Griffin" value="<?php rememberInputValue('loginUsername') ?>" required>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" placeholder="Your Password" required>
                    </p>
                    <button type="submit" name="loginButton">Login</button>

                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account yet? Signup here.</span>
                    </div>

                </form>
                <!-----------------------------LOGIN FORM END----------------------------->

                <!-----------------------------REGISTER FORM START----------------------------->
                <form id="registerForm" action="register.php" method="POST">
                    <h2>Create your free account</h2>

                    <p>
                        <?php echo $account->getError(Constants::$usernameLengthErrorMsg); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" placeholder="e.g. Peter Griffin" value="<?php rememberInputValue('username') ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$firstNameLengthErrorMsg); ?>
                        <label for="firstname">First name</label>
                        <input id="firstname" name="firstName" type="text" placeholder="e.g. Peter" value="<?php rememberInputValue('firstName') ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$lastNameLengthErrorMsg); ?>
                        <label for="lastname">Last name</label>
                        <input id="lastname" name="lastName" type="text" placeholder="e.g. Griffin" value="<?php rememberInputValue('lastName') ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatchErrorMsg); ?>
                        <?php echo $account->getError(Constants::$emailFormatErrorMsg); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="e.g. Peter@gmail.com" value="<?php rememberInputValue('email') ?>" required>
                    </p>

                    <p>
                        <label for="confirmEmail">Confirm email</label>
                        <input id="confirmEmail" name="confirmEmail" type="email" placeholder="e.g. Peter@gmail.com" value="<?php rememberInputValue('confirmEmail') ?>" required>
                    </p>

                    <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatchErrorMsg); ?>
                        <?php echo $account->getError(Constants::$passwordsNotAlphanumericErrorMsg); ?>
                        <?php echo $account->getError(Constants::$passwordsLengthErrorMsg); ?>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Your Password" required>
                    </p>

                    <p>
                        <label for="confirmPassword">Confirm password</label>
                        <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Your Password" required>
                    </p>

                    <button type="submit" name="registerButton">Sign Up</button>

                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Log in here.</span>
                    </div>

                </form>
            </div>
            <!-----------------------------REGISTER FORM END----------------------------->

            <!-----------------------------RIGHT COLUMN START----------------------------->
            <div id="loginText">
                <h1> Get great music, right now </h1>
                <h2> Listen to loads of songs for free </h2>
                <ul>
                    <li>Discover music you'll fall in love with</li>
                    <li>Create your own playlist</li>
                    <li>Follow artists to keep up to date</li>
                </ul>

            </div>
            <!-----------------------------RIGHT COLUMN END----------------------------->
        </div>
    </div>

</body>
</html>