// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var names = document.querySelectorAll(".anime-name");

   names.forEach(function (div) {
      adjustFontSize(div);
   });
});

function adjustFontSize(div) {
   var name = div.querySelector("p");
   var containerWidth = name.clientWidth;
   var textWidth = name.scrollWidth;

   if (textWidth > containerWidth) {
      var fontSize = parseInt(window.getComputedStyle(name).fontSize);
      fontSize -= 1;
      name.style.fontSize = fontSize + "px";

      adjustFontSize(div);
   }
}
