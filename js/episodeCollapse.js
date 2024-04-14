// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var collapsibles = document.querySelectorAll(".collapsible");
   if (collapsibles.length > 1) {
      collapsibles.forEach(function (div) {
         var collapsibleBtn = div.querySelector(".collapsible-btn");
         var episodeSection = div.querySelector(".episode-section");
         var episodeItems = episodeSection.querySelectorAll(".episode");

         collapsibleBtn.addEventListener("click", function () {
            if (episodeSection.style.display === "block") {
               episodeSection.style.display = "none";
            } else {
               episodeSection.style.display = "block";
            }
            episodeItems.forEach(function (item, index) {
               setTimeout(function () {
                  item.classList.toggle("hidden");
               }, index * 25); // Adjust the delay time (in milliseconds) as needed
            });
         });
      });
   } else {
      var episodeSection = document.querySelector(".episode-section");
      var episodeItems = episodeSection.querySelectorAll(".episode");

      episodeSection.style.display = "block";

      episodeItems.forEach(function (item, index) {
         setTimeout(function () {
            item.classList.toggle("hidden");
         }, index * 25); // Adjust the delay time (in milliseconds) as needed
      });
   }
});
