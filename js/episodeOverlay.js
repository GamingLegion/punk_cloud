// JavaScript Document
var thumbnailImg = '';
var episodeName = '';

document.addEventListener("DOMContentLoaded", function () {
   var overlay = document.getElementById("episodeOverlay");
   var episodeElements = document.querySelectorAll(".episode");

   document.addEventListener("click", function (event) {
      var showing = false;
      episodeElements.forEach(function (episode) {
         if (episode.contains(event.target)) {
            showing = true;
         }
      });

      if (!overlay.contains(event.target) && !showing) {
         closeOverlay();
      }
   });

   episodeElements.forEach(function (episode) {
      episode.addEventListener("click", function () {
         thumbnailImg = episode.querySelector(".episode-thumbnail").querySelector("img").src;
         episodeName = episode.querySelector("h3").textContent;
         showOverlay();
      });
   });
});

function showOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.add("active");
   overlay.querySelector("#overlayImg").querySelector("img").src = thumbnailImg;
   overlay.querySelector("#title").textContent = episodeName;
}

function closeOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.remove("active");
}
