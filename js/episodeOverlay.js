// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var overlay = document.getElementById("episodeOverlay");
   var episodes = document.querySelectorAll(".episode");

   document.addEventListener("click", function (event) {
      var showing = false;
      episodes.forEach(function (episode) {
         if (episode.contains(event.target) && !event.target.matches('.checkbox-btn') && !event.target.matches('.checkbox-text') && !event.target.matches('.popup') && !event.target.matches('.popupBtn')) {
            showing = true;
         }
      });

      if (!overlay.contains(event.target) && !showing) {
         closeOverlay();
      }
   });
});

function showOverlay(episode) {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.add("active");
   overlay.querySelectorAll("input")[0].value = episode.getAttribute('data-romName');
   overlay.querySelectorAll("input")[1].value = episode.getAttribute('data-season');
   overlay.querySelectorAll("input")[2].value = episode.getAttribute('data-epiNum');
   overlay.querySelector("#overlayImg").querySelector("img").src = episode.getAttribute('data-thumbnail');
   overlay.querySelector("#title").textContent = episode.getAttribute('data-epiName');
   overlay.querySelector("#release_date").textContent = episode.getAttribute('data-relDate');
   overlay.querySelector("#description").textContent = episode.getAttribute('data-epiName');
   if (overlay.querySelectorAll(".overlayCheck").length === 1) {
      if (episode.querySelector(".checkbox-btn").classList.contains("checked")) {
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
