// JavaScript Document
var thumbnailImg = '';
var episodeName = '';

var rom_name = '';
var season = '';
var epiNum = '';
var release_date = '';

document.addEventListener("DOMContentLoaded", function () {
   var overlay = document.getElementById("episodeOverlay");
   var episodes = document.querySelectorAll(".episode");

   document.addEventListener("click", function (event) {
      var showing = false;
      episodes.forEach(function (episode) {
         if (episode.contains(event.target)) {
            showing = true;
         }
      });

      if (!overlay.contains(event.target) && !showing) {
         closeOverlay();
      }
   });

   episodes.forEach(function (episode) {
      episode.addEventListener("click", function () {
         thumbnailImg = episode.querySelector(".episode-thumbnail").querySelector("img").src;
         episodeName = episode.querySelector("h3").textContent;
         
         rom_name = episode.querySelectorAll("input")[2].value;
         season = episode.querySelector(".episode-info").id;
         epiNum = episode.querySelectorAll("input")[1].value;
         release_date = episode.querySelectorAll("input")[3].value;
         showOverlay();
      });
   });
});

function showOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.add("active");
   overlay.querySelectorAll("input")[0].value = rom_name;
   overlay.querySelectorAll("input")[1].value = season;
   overlay.querySelectorAll("input")[2].value = epiNum;
   overlay.querySelector("#overlayImg").querySelector("img").src = thumbnailImg;
   overlay.querySelector("#title").textContent = episodeName;
   overlay.querySelector("#release_date").textContent = release_date;
   overlay.querySelector("#descripion").textContent = episodeName;
}

function closeOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.remove("active");
}
