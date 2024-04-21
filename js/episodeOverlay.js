// JavaScript Document
var thumbnailImg = '';
var episodeName = '';
var checked = false;

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
         if (episode.contains(event.target) && !event.target.matches('.checkbox-btn') && !event.target.matches('.popup') && !event.target.matches('.popupBtn')) {
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
         if (episode.querySelector("button").classList.contains("checked")) {
            checked = true;
         } else  {
            checked = false;
         }

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
   overlay.querySelector("#description").textContent = episodeName;
   if (overlay.querySelectorAll(".overlayCheck").length === 1) {
      if (checked) {
         overlay.querySelector(".overlayCheck").classList.remove("unchecked");
         overlay.querySelector(".overlayCheck").classList.add("checked");
      } else {
         overlay.querySelector(".overlayCheck").classList.remove("checked");
         overlay.querySelector(".overlayCheck").classList.add("unchecked");
      }
   }
}

function closeOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.remove("active");
   overlay.querySelector(".overlayCheck").classList.remove("checked");
   overlay.querySelector(".overlayCheck").classList.add("unchecked");
}
