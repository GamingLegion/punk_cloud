// JavaScript Document
document.getElementById("signout").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/tools/signout.php", true);
    xhr.send();
});