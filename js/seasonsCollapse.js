// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var collapsibles = document.querySelectorAll(".collapsible");
   if (collapsibles.length > 1) {
      collapsibles.forEach(function (div) {
         var collapsibleBtn = div.querySelector(".collapsible-btn");
         var description = div.querySelector(".anime-description");
         var episodeSection = div.querySelector(".episode-section");
         var episodeItems = episodeSection.querySelectorAll(".episode");

         collapsibleBtn.addEventListener("click", function () {
            if (description.style.display === "block") {
               description.style.display = "none";
            } else {
               description.style.display = "block";
            }
            if (episodeSection.style.display === "block") {
               episodeSection.style.display = "none";
            } else {
               episodeSection.style.display = "block";
            }
            episodeItems.forEach(function (item, index) {
               setTimeout(function () {
                  item.classList.toggle("hidden");
               }, index * 25);
            });
         });
      });
   } else if (collapsibles.length === 1) {
      var description = document.querySelector(".anime-description");
      var episodeSection = document.querySelector(".episode-section");
      var episodeItems = episodeSection.querySelectorAll(".episode");

      description.style.display = "block";
      episodeSection.style.display = "block";

      episodeItems.forEach(function (item, index) {
         setTimeout(function () {
            item.classList.toggle("hidden");
         }, index * 25);
      });
   }
});
