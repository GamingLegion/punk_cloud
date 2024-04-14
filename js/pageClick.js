// JavaScript Document

var divs = document.querySelectorAll(".aniCard");

divs.forEach(function (div) {
   div.addEventListener("click", function () {
      var name = this.querySelector("p").title;
      var link = "http://localhost/PunkCloud/php/animePage.php?link=" + name;
      window.location.href = link;
   });
});
