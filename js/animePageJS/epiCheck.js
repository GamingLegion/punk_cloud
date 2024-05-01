// JavaScript Document
document.addEventListener("click", function (event) {
   var popups = document.querySelectorAll(".popupContainer");
   popups.forEach(function (pop) {
      if (pop.style.display === "block" && !event.target.matches('.checkbox-text') && !event.target.matches('.popup') && !event.target.matches('.popupBtn')) {
         closePopup();
      }
   });
});

function incrementCheck(button, collapse) {
   var buttonbtn = button.querySelector("button");
   if (!button.classList.contains("section-check-wrapper")) {
      if (buttonbtn.classList.contains("unchecked")) {
         epiCheck(0, button);
         var index = buttonbtn.getAttribute("data-epiNum");
         if (index > 1) {
            var prevEpi = document.querySelectorAll('div.collapsible[data-value]')[collapse - 1].querySelectorAll("div.episode[data-epiNum]")[index - 2].querySelector(".checkbox-btn");
            if (prevEpi.classList.contains("unchecked")) {
               openPopup(collapse, buttonbtn.dataset.epinum, 'a');
            }
         }
      } else {
         openPopup(collapse, buttonbtn.dataset.epinum, 'b');
      }
   } else {
      if (buttonbtn.classList.contains("checked")) {
         openPopup(button.dataset.value, 0, 'c');
      } else {
         SoptionSelected(3, button.dataset.value);
      }
   }
   sectionHeadCheck(collapse);
}

function openPopup(collapse, index, ab) {
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
   var buttontxt = episode.querySelector(".checkbox-text");
   if (option === 1) {
      epiIncDec(0, 0, button);
   } else if (option === 2) {
      epiIncDec(1, 0, button);
   } else if (option === 3) {
      buttontxt.innerHTML = "&#10003;";
      buttontxt.style.fontSize = '30px';
      buttontxt.style.margin = '-3px -28px';
      epiCheck(0, button);
   } else if (option === 4) {
      checkPrev(collapseIndex, epiNum);
   }
   closePopup();
   sectionHeadCheck(collapseIndex);
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
      var buttontxt = episode.querySelector(".checkbox-text");
      if (option === 1) {
         epiIncDec(0, 0, button);
      } else if (option === 2) {
         epiIncDec(1, 0, button);
      } else {
         buttontxt.innerHTML = "&#10003;";
         buttontxt.style.fontSize = '30px';
         buttontxt.style.margin = '-3px -28px';
         setTimeout(function () {
            epiCheck(sbuttonbtn.classList.contains("checked"), button);
         }, index * 25);
      }
   });
   closePopup();
}

function checkPrev(collapseIndex, epiNum) {
   var episodes = document.querySelectorAll('div.collapsible[data-value]')[collapseIndex - 1].querySelectorAll("div.episode[data-epiNum]");
   episodes.forEach(function (epi) {
      var btn = epi.querySelector(".checkbox-btn");
      if (btn.dataset.epinum < epiNum && btn.classList.contains("unchecked")) {
         setTimeout(function () {
            epiCheck(0, epi);
         }, btn.dataset.epinum * 25);
      }
   });
}

function epiCheck(check, button) {
   var buttonbtn = button.querySelector("button");

   var data = {
      epi_num: buttonbtn.dataset.epinum,
      rom_name: buttonbtn.dataset.romname,
      season: buttonbtn.dataset.season
   };

   var xhr = new XMLHttpRequest();
   if (check !== 0) {
      if (check !== buttonbtn.classList.contains('checked')) {
         xhr.open('POST', '/PunkCloud/php/tools/epiCheck.php', true);
         xhr.setRequestHeader('Content-Type', 'application/json');
         xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
               if (!buttonbtn.classList.contains("checkbox-btn")) {
                  var btn = document.querySelector('.checkbox-btn');
                  btn.classList.remove('checked');
                  btn.classList.add('unchecked');
               }
               buttonbtn.classList.toggle('unchecked');
               buttonbtn.classList.toggle('checked');
            }
         };
         xhr.send(JSON.stringify(data));
      }
   } else {
      xhr.open('POST', '/PunkCloud/php/tools/epiCheck.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function () {
         if (xhr.readyState === 4 && xhr.status === 200) {
            buttonbtn.classList.toggle('unchecked');
            buttonbtn.classList.toggle('checked');
         }
      };
      xhr.send(JSON.stringify(data));
   }
}

function epiIncDec(incdec, index, button) {
   var buttonbtn = button.querySelector("button");
   var buttontxt = button.querySelector("p");

   var data = {
      incdec: incdec,
      epi_num: buttonbtn.dataset.epinum,
      rom_name: buttonbtn.dataset.romname,
      season: buttonbtn.dataset.season
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '/PunkCloud/php/tools/epiIncDec.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         checkboxText(incdec, index, buttonbtn, buttontxt);
      }
   };
   xhr.send(JSON.stringify(data));
}

function checkboxText(incdec, index, buttonbtn, buttontxt) {
   var text = buttontxt.textContent;
   if (index === 0) {
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
   } else {
      if (incdec === 0) { // Increment
         if (text === '✓') {
            buttontxt.innerHTML = 'x2';
            buttontxt.style.fontSize = '25px';
            buttontxt.style.margin = '3px 5px';
         } else {
            text = parseInt(text.substring(1));
            text++;
            buttontxt.innerHTML = "x" + text;
            if (text < 10) {
               buttontxt.style.fontSize = '25px';
               buttontxt.style.margin = '3px 5px';
            } else if (text < 100) {
               buttontxt.style.fontSize = '18px';
               buttontxt.style.margin = '7px 4px';
            } else if (text < 1000) {
               buttontxt.style.fontSize = '13px';
               buttontxt.style.margin = '9px 4px';
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
                  buttontxt.style.margin = '3px 5px';
               } else if (text < 100) {
                  buttontxt.style.fontSize = '18px';
                  buttontxt.style.margin = '7px 4px';
               } else if (text < 1000) {
                  buttontxt.style.fontSize = '13px';
                  buttontxt.style.margin = '9px 4px';
               }
            } else {
               buttontxt.innerHTML = "&#10003;";
               buttontxt.style.fontSize = '30px';
               buttontxt.style.margin = '-2px 6px';
            }
         }
      }
   }
}

function updateRank(season, rank) {
   var data = {
      season: season,
      rank: rank.value
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '/PunkCloud/php/tools/epiIncDec.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.send(JSON.stringify(data));
}

function sectionHeadCheck(collapse) {
   var collapsi = document.querySelectorAll(".collapsible[data-value]")[collapse - 1];
   var allBtns = collapsi.querySelector("#collapsible").querySelectorAll(".checkbox-btn");
   var check = true;
   for (const epi of allBtns) {
      if (epi.classList.contains("unchecked")) {
         check = false;
      }
   }
   
   var secBtn = collapsi.querySelector(".checkbox-btn");
   if(check) {
      secBtn.classList.remove("unchecked");
      secBtn.classList.add("checked");
   } else {
      secBtn.classList.remove("checked");
      secBtn.classList.add("unchecked");
   }
}

