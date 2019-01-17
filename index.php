<?php
include("includes/config.php");

//session_destroy();

if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
}
else{
    header("Location: register.php");
}

?>


<html>
<head>
    <title>Welcome to Spootify</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    
    <div id = "nowPlayingBarContainer">

    </div>

</body>
</html>