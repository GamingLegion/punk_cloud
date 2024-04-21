// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var collapsibles = document.querySelectorAll(".collapsible");
   if (collapsibles.length > 1) {
      collapsibles.forEach(function (div) {
         var collapsibleBtn = div.querySelector(".collapsible-btn");
         var left = div.querySelector(".anime-left");
         var infoBtn = div.querySelector(".season_info");
         var episodeSection = div.querySelector(".episode-section");
         var episodeItems = episodeSection.querySelectorAll(".episode");

         collapsibleBtn.addEventListener("click", function () {
            if (left.style.display === "block") {
               left.style.display = "none";
               episodeSection.style.display = "none";
            } else {
               left.style.display = "block";
               episodeSection.style.display = "block";
            }
            episodeItems.forEach(function (item, index) {
               setTimeout(function () {
                  item.classList.toggle("hidden");
               }, index * 25);
            });
         });
         infoBtn.addEventListener("click", function () {
            var info = left.querySelectorAll(".anime-description")[2];
            if (info.style.display === "block") {
               info.style.display = "none";
               infoBtn.textContent = "Show Season Info";
            } else {
               info.style.display = "block";
               infoBtn.textContent = "Hide Season Info";
            }
         });
      });
   } else if (collapsibles.length === 1) {
      var left = document.querySelector(".anime-left");
      var info = document.querySelector(".season_info");
      var episodeSection = document.querySelector(".episode-section");
      var episodeItems = episodeSection.querySelectorAll(".episode");

      left.style.display = "block";
      info.style.display = "block";
      episodeSection.style.display = "block";

      episodeItems.forEach(function (item, index) {
         setTimeout(function () {
            item.classList.toggle("hidden");
         }, index * 25);
      });
   }
});
