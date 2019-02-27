//Once the page DOM(Document Object Model) is ready, then allow the following functions.
$(document).ready(function(){
   //Hides login form and shows register form
   $("#hideLogin").click(function(){
        //console.log("hideLogin");
        $("#loginForm").hide();
        $("#registerForm").show();
   });
   //Hides register form and shows login form
   $("#hideRegister").click(function(){
        //console.log("hideRegister");
        $("#registerForm").hide();
        $("#loginForm").show();
   });
});