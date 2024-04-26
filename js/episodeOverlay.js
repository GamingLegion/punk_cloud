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
   overlay.querySelector("#overlayImg").querySelector("img").src = episode.dataset.thumbnail;
   overlay.querySelector("#title").textContent = episode.dataset.epiname;
   overlay.querySelector("#release_date").textContent = episode.dataset.reldate;
   overlay.querySelector("#description").textContent = episode.dataset.epiname;
   if (overlay.querySelectorAll(".checkbox-btn").length === 1) {
      var overCheck = overlay.querySelector(".checkbox-btn");
      var overText = overlay.querySelector(".checkbox-text");
      var epiCheck = episode.querySelector(".checkbox-btn");
      var epiText = episode.querySelector(".checkbox-text");

      overCheck.dataset.romname = epiCheck.dataset.romname;
      overCheck.dataset.season = epiCheck.dataset.season;
      overCheck.dataset.epinum = epiCheck.dataset.epinum;

      if (epiCheck.classList.contains("checked")) {
         overCheck.classList.remove("unchecked");
         overCheck.classList.add("checked");

         overText.innerHTML = epiText.innerHTML;
         var text = epiText.textContent.substr(1);
         if (epiText.innerHTML === '✓') {
            overText.style.fontSize = '30px';
            overText.style.margin = '-2px 6px';
         } else if (text < 10) {
            overText.style.fontSize = '25px';
            overText.style.margin = '3px 5px';
         } else if (text < 100) {
            overText.style.fontSize = '18px';
            overText.style.margin = '7px 4px';
         } else if (text < 1000) {
            overText.style.fontSize = '13px';
            overText.style.margin = '9px 4px';
         }
      } else {
         overCheck.classList.remove("checked");
         overCheck.classList.add("unchecked");
      }
   }
}

function closeOverlay() {
   var overlay = document.getElementById("episodeOverlay");
   overlay.classList.remove("active");
   overlay.querySelector(".checkbox-btn").classList.remove("checked");
   overlay.querySelector(".checkbox-btn").classList.add("unchecked");
   overlay.querySelector(".checkbox-text").innerHTML = '&#10003;';
}

function incCheck(button) {
   var btn = button.querySelector("button");
   if (btn.classList.contains("checked")) {
      openPop();
   } else {
      epiCheck(0, button);
      var epi = searchEpi(btn);
      epi.classList.remove("unchecked");
      epi.classList.add("checked");
   }
}

function openPop() {
   document.querySelector('#episodeOverlay').querySelector('#popupContainer').style.display = "block";
}

function closePop() {
   document.querySelector('#episodeOverlay').querySelector('#popupContainer').style.display = "none";
}

function optSel(option) {
   var checkbox = document.querySelector('#episodeOverlay').querySelector(".check");
   var checkboxbtn = checkbox.querySelector(".checkbox-btn");
   var checkboxtxt = checkbox.querySelector(".checkbox-text");
   var epi, txt;

   if (option === 1) {
      epiIncDec(0, 1, checkbox);
      epi = searchEpi(checkboxbtn);
      txt = epi.closest(".check").querySelector(".checkbox-text");
      checkboxText(0, 0, epi, txt);
   } else if (option === 2) {
      epiIncDec(1, 1, checkbox);
      epi = searchEpi(checkboxbtn);
      txt = epi.closest(".check").querySelector(".checkbox-text");
      checkboxText(1, 0, epi, txt);
      if (checkbox.classList.contains("unchecked")) {
         epi.classList.remove("checked");
         epi.classList.add("unchecked");
      } else {
         epi.classList.remove("unchecked");
         epi.classList.add("checked");
      }
   } else if (option === 3) {
      checkboxtxt.innerHTML = "&#10003;";
      checkboxtxt.style.fontSize = '30px';
      checkboxtxt.style.margin = '-2px 6px';
      epiCheck(0, checkbox);
      epi = searchEpi(checkboxbtn);
      txt = epi.closest(".check").querySelector(".checkbox-text");
      txt.innerHTML = "&#10003;";
      txt.style.fontSize = '30px';
      txt.style.margin = '-3px -29px';
      epi.classList.remove("checked");
      epi.classList.add("unchecked");
   }
   closePop();
}

function searchEpi(button) {
   var allBtns = document.querySelectorAll(".checkbox-btn");
   for (const epi of allBtns) {
      if (epi.dataset.romname === button.dataset.romname
         && epi.dataset.season === button.dataset.season
         && epi.dataset.epinum === button.dataset.epinum
         && epi.id !== "over") {
         return epi;
      }
   }
   return null;
}
