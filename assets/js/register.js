$(document).ready(function(){
   $("#hideLogin").click(function(){
        console.log("hideLogin");
        $("#loginForm").hide();
        $("#registerForm").show();
   });

   $("#hideRegister").click(function(){
        console.log("hideRegister");
        $("#loginForm").show();
        $("#registerForm").hide();
   });
});