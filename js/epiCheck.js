// JavaScript Document
var overlay = document.querySelector('#episodeOverlay');
var button = document.querySelector('.overlayCheck');
button.addEventListener('click', function () {
   var epi_num = overlay.querySelector("input[name='epi_num']").value;
   var rom_name = overlay.querySelector("input[name='anime_name']").value;
   var season = overlay.querySelector("input[name='anime_season']").value;

   epiCheck(button, epi_num, rom_name, season);
});

document.addEventListener("click", function (event) {
   var popups = document.querySelectorAll(".popupContainer");
   popups.forEach(function (pop) {
      if (pop.style.display === "block" && !event.target.matches('.checkbox-text') && !event.target.matches('.popup') && !event.target.matches('.popupBtn')) {
         closePopup();
      }
   });
});

function epiCheck(button, epi_num, rom_name, season) {
   var buttonbtn = button.querySelector("button");

   var data = {
      epi_num: epi_num,
      rom_name: rom_name,
      season: season
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/epiCheck.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         if (!buttonbtn.classList.contains("overlayCheck")) {
            var btn = document.querySelector('.overlayCheck');
            btn.classList.remove('checked');
            btn.classList.add('unchecked');
         }
         buttonbtn.classList.toggle('unchecked');
         buttonbtn.classList.toggle('checked');
      }
   };
   xhr.send(JSON.stringify(data));
}

function epiCheck2(check, button, epi_num, rom_name, season) {
   var buttonbtn = button.querySelector("button");

   var data = {
      epi_num: epi_num,
      rom_name: rom_name,
      season: season
   };

   if (check !== buttonbtn.classList.contains('checked')) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '../php/tools/epiCheck.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function () {
         if (xhr.readyState === 4 && xhr.status === 200) {
            if (!buttonbtn.classList.contains("overlayCheck")) {
               var btn = document.querySelector('.overlayCheck');
               btn.classList.remove('checked');
               btn.classList.add('unchecked');
            }
            buttonbtn.classList.toggle('unchecked');
            buttonbtn.classList.toggle('checked');
         }
      };
      xhr.send(JSON.stringify(data));
   }
}

function epiIncDec(incdec, button, epi_num, rom_name, season) {
   var buttonbtn = button.querySelector("button");
   var buttontxt = button.querySelector("p");

   var data = {
      incdec: incdec,
      epi_num: epi_num,
      rom_name: rom_name,
      season: season
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/epiIncDec.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         checkboxText(incdec, buttonbtn, buttontxt);
      }
   };
   xhr.send(JSON.stringify(data));
}

function checkboxText(incdec, buttonbtn, buttontxt) {
   var text = buttontxt.textContent;
   if (incdec === 0) { // Increment
      if (text === '✓') {
         buttontxt.innerHTML = 'x2';
         buttontxt.style.fontSize = '25px';
         buttontxt.style.margin = '3px -30px';
      } else {
         text = parseInt(text.substring(1));
         text++;
         buttontxt.innerHTML = "x" + text;
         if (text < 10) {
            buttontxt.style.fontSize = '25px';
            buttontxt.style.margin = '3px -30px';
         } else if (text < 100) {
            buttontxt.style.fontSize = '18px';
            buttontxt.style.margin = '7px -30px';
         } else if (text < 1000) {
            buttontxt.style.fontSize = '13px';
            buttontxt.style.margin = '9px -30px';
         }
      }
   } else if (incdec === 1) { // Decrement
      if (text === '✓') {
         buttonbtn.classList.toggle('unchecked');
         buttonbtn.classList.toggle('checked');
      } else {
         text = parseInt(text.substring(1));
         text--;
         if (text > 1) {
            buttontxt.innerHTML = "x" + text;
            if (text < 10) {
               buttontxt.style.fontSize = '25px';
               buttontxt.style.margin = '3px -30px';
            } else if (text < 100) {
               buttontxt.style.fontSize = '18px';
               buttontxt.style.margin = '7px -30px';
            } else if (text < 1000) {
               buttontxt.style.fontSize = '13px';
               buttontxt.style.margin = '9px -30px';
            }
         } else {
            buttontxt.innerHTML = "&#10003;";
            buttontxt.style.fontSize = '30px';
            buttontxt.style.margin = '-3px -28px';
         }
      }
   }
}

function incrementCheck(button, collapse) {
   var buttonbtn = button.querySelector("button");
   if (!button.classList.contains("section-check-wrapper")) {
      if (buttonbtn.classList.contains("unchecked")) {
         epiCheck(button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
         var index = buttonbtn.getAttribute("data-epiNum");
         if (index > 1) {
            var prevEpi = document.querySelectorAll('div.collapsible[data-value]')[collapse - 1].querySelectorAll("div.episode[data-epiNum]")[index - 2].querySelector(".checkbox-btn");
            if (prevEpi.classList.contains("unchecked")) {
               openPopup(button, collapse, buttonbtn.getAttribute('data-epiNum'), 'a');
            }
         }
      } else {
         openPopup(button, collapse, buttonbtn.getAttribute('data-epiNum'), 'b');
      }
   } else {
      if (buttonbtn.classList.contains("checked")) {
         openPopup(button, button.getAttribute('data-value'), 0, 'c');
      } else {
         SoptionSelected(3, button.getAttribute('data-value'));
      }
   }
}

function openPopup(button, collapse, index, ab) {
   if (ab !== 'c') {
      document.querySelectorAll("#collapsible")[collapse - 1].querySelectorAll('#popupContainer[data-val="' + ab + '"]')[index - 1].style.display = "block";
   } else {
      document.querySelectorAll('#popupContainer[data-val="c"]')[collapse - 1].style.display = "block";
   }
}

function closePopup() {
   var popups = document.querySelectorAll('#popupContainer');
   popups.forEach(function (pop) {
      pop.style.display = "none";
   });
}

function optionSelected(option, epiNum, collapseIndex) {
   var episode = document.querySelectorAll('div.collapsible[data-value]')[collapseIndex - 1].querySelectorAll("div.episode[data-epiNum]")[epiNum - 1];
   var button = episode.querySelector(".check");
   var buttonbtn = episode.querySelector(".checkbox-btn");
   var buttontxt = episode.querySelector(".checkbox-text");
   if (option === 1) {
      epiIncDec(0, button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
   } else if (option === 2) {
      epiIncDec(1, button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
   } else if (option === 3) {
      buttontxt.innerHTML = "&#10003;";
      buttontxt.style.fontSize = '30px';
      buttontxt.style.margin = '-3px -28px';
      epiCheck(button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
   } else if (option === 4) {
      checkPrev(collapseIndex, epiNum);
   }
   closePopup();
}

function checkPrev(collapseIndex, epiNum) {
   var episodes = document.querySelectorAll('div.collapsible[data-value]')[collapseIndex - 1].querySelectorAll("div.episode[data-epiNum]");
   episodes.forEach(function (epi) {
      var btn = epi.querySelector(".checkbox-btn");
      if (btn.getAttribute("data-epiNum") < epiNum && btn.classList.contains("unchecked")) {
         setTimeout(function () {
            epiCheck(epi, btn.getAttribute('data-epiNum'), btn.getAttribute('data-romName'), btn.getAttribute('data-season'));
         }, btn.getAttribute("data-epiNum") * 25);
      }
   });
}

function SoptionSelected(option, collapseIndex) {
   var collapse = document.querySelectorAll('div.collapsible[data-value]')[collapseIndex - 1];
   var episodes = collapse.querySelectorAll("div.episode[data-epiNum]");

   var sbutton = collapse.querySelector(".section-check-wrapper");
   var sbuttonbtn = sbutton.querySelector(".checkbox-btn");
   var sbuttontxt = sbutton.querySelector(".checkbox-text");
   if (option === 1) {
      checkboxText(0, sbuttonbtn, sbuttontxt);
   } else if (option === 2) {
      checkboxText(1, sbuttonbtn, sbuttontxt);
   } else {
      sbuttonbtn.classList.toggle('unchecked');
      sbuttonbtn.classList.toggle('checked');
      sbuttontxt.innerHTML = "&#10003;";
      sbuttontxt.style.fontSize = '30px';
      sbuttontxt.style.margin = '-3px -29px';
   }

   episodes.forEach(function (episode, index) {
      var button = episode.querySelector(".check");
      var buttonbtn = episode.querySelector(".checkbox-btn");
      var buttontxt = episode.querySelector(".checkbox-text");
      if (option === 1) {
         epiIncDec(0, button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
      } else if (option === 2) {
         epiIncDec(1, button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
      } else {
         buttontxt.innerHTML = "&#10003;";
         buttontxt.style.fontSize = '30px';
         buttontxt.style.margin = '-3px -28px';
         setTimeout(function () {
            epiCheck2(sbuttonbtn.classList.contains("checked"), button, buttonbtn.getAttribute('data-epiNum'), buttonbtn.getAttribute('data-romName'), buttonbtn.getAttribute('data-season'));
         }, index * 25);
      }
   });
   closePopup();
}

function updateRank(season, rank) {
   var data = {
      season: season,
      rank: rank.value
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/updateRank.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.send(JSON.stringify(data));
}
