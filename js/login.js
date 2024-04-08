// JavaScript Document
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // You can perform client-side validation here if needed

    // Send the login data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/tools/login.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = xhr.responseText;
            if (response === "success") {
                window.location.href = "home.php";
            } else {
                document.getElementById("error-msg").innerText = "Invalid username or password.";
            }
        }
    };
    xhr.send("username=" + username + "&password=" + password);
});
