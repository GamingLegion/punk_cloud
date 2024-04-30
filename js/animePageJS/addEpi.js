// JavaScript Document
function addEpisode(addDiv) {
   var section = addDiv.closest(".episode-section");
   var lastEpi = section.querySelector(".episode[data-epiNum=\"" + (addDiv.dataset.epinum - 1) + "\"]");
   
   var newEpi = lastEpi.cloneNode(true);
   newEpi.dataset.epinum = addDiv.dataset.epinum;
   addDiv.dataset.epinum++;
   newEpi.dataset.epiname = "Episode " + newEpi.dataset.epinum;
   
   var newName = newEpi.querySelector("h3");
   newName.textContent = newEpi.dataset.epiname;
   
   var newCheck = newEpi.querySelector(".checkbox-btn");
   newCheck.dataset.epinum = newEpi.dataset.epinum;
   
   var newPopupA = newEpi.querySelectorAll(".popupContainer")[0];
   var popupbtns = newPopupA.querySelectorAll("button");
   popupbtns.forEach(function(btn) {
      var oc = btn.onclick.toString();
      oc = oc.replace('function onclick(event) {\n', '');
      oc = oc.replace('\n}', '');
      oc = oc.replace(', ' + (newEpi.dataset.epinum - 1) + ',', ', ' + newEpi.dataset.epinum + ',');
      btn.setAttribute('onclick', oc);
   });
   
   var newPopupB = newEpi.querySelectorAll(".popupContainer")[1];
   popupbtns = newPopupB.querySelectorAll("button");
   popupbtns.forEach(function(btn) {
      var oc = btn.onclick.toString();
      oc = oc.replace('function onclick(event) {\n', '');
      oc = oc.replace('\n}', '');
      oc = oc.replace(', ' + (newEpi.dataset.epinum - 1) + ',', ', ' + newEpi.dataset.epinum + ',');
      btn.setAttribute('onclick', oc);
   });
   
   section.insertBefore(newEpi, addDiv);
   
   var data = {
      epi_num: newEpi.dataset.epinum,
      rom_name: newEpi.dataset.romname,
      series: getSeries(),
      season: newEpi.dataset.season
   };
   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/addEpi.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.send(JSON.stringify(data));
}

function getSeries() {
   return document.querySelector(".anime-names").querySelector(".rom_name").textContent;
}