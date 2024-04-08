// JavaScript Document

var divs = document.querySelectorAll(".card");

// Loop through each div and attach a click event listener
divs.forEach(function(div) {
    div.addEventListener("click", function() {
		var name = this.querySelector("p").innerText;
		var link = "http://localhost/PunkCloud/php/entryPage.php?link=" + name;

        window.location.href = link; // Redirect to the specified URL
    });
});