// JavaScript Document
document.getElementById("loginForm").addEventListener("submit", function (event) {
   event.preventDefault();
   var username = document.getElementById("username").value;
   var password = document.getElementById("password").value;

   var xhr = new XMLHttpRequest();
   xhr.open("POST", "/php/tools/login.php", true);
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
         var response = xhr.responseText;
         if (response === "fail") {
            document.getElementById("error-msg").innerText = "Invalid username/email or password";
         } else {
            window.location.href = "../php/home.php";
            
         }
      }
   };
   xhr.send("username=" + username + "&password=" + password);
   
});
