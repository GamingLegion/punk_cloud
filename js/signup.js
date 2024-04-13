// JavaScript Document
document.getElementById("signupForm").addEventListener("submit", function (event) {
   event.preventDefault();
   var email = document.getElementById("email").value;
   var username = document.getElementById("username").value;
   var password = document.getElementById("password").value;

   var xhr = new XMLHttpRequest();
   xhr.open("POST", "../php/tools/signup.php", true);
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
         var response = xhr.responseText;
         if (response === "userFail") {
            document.getElementById("error-msg").innerText = "Username is already taken";
         } else if (response === "mailFail") {
            document.getElementById("error-msg").innerText = "Email is already in use";
         } else if (response === "invalMail") {
            document.getElementById("error-msg").innerText = "That is not a valid email";
         } else {
            window.location.href = "../php/home.php";
         }
      }
   };
   xhr.send("email=" + email + "&username=" + username + "&password=" + password);
});
