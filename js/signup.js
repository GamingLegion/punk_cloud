// JavaScript Document
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var email = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // You can perform client-side validation here if needed

    // Send the login data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/tools/signup.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = xhr.responseText;
            if (response === "userFail") {
                document.getElementById("error-msg").innerText = "Username is already taken";
            } else if (response === "mailFail") {
                document.getElementById("error-msg").innerText = "Email is already in use";
            } else {
               window.location.href = "home.php";
            }
        }
    };
    xhr.send("email=" + email + "username=" + username + "&password=" + password);
});
