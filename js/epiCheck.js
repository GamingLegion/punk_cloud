// JavaScript Document
var collapsibles = document.querySelectorAll('.collapsible');
collapsibles.forEach(function (div) {
   var season = div.querySelector('input').value;
   var sectBtn = div.querySelector('#sectionCheck');
   var epis = div.querySelectorAll('.episode');

   sectBtn.addEventListener('click', function () {
      epis.forEach(function (epi, index) {
         var user = epi.querySelectorAll("input")[0].value;
         var epi_name = epi.querySelector("h3").textContent;
         var epi_num = epi.querySelectorAll("input")[1].value;
         var rom_name = epi.querySelectorAll("input")[2].value;
         setTimeout(function() {
            check(user, epi_name, epi_num, rom_name, season);
         }, index * 25);
      });

      // Toggle class for section checkbox
      sectBtn.classList.toggle('unchecked');
      sectBtn.classList.toggle('checked');
   });

   epis.forEach(function (epi) {
      var user = epi.querySelector("input[name='username']").value;
      var epi_name = epi.querySelector("h3").textContent;
      var epi_num = epi.querySelector("input[name='epi_num']").value;
      var rom_name = epi.querySelector("input[name='rom_name']").value;
      var button = epi.querySelector('button');
      button.addEventListener('click', function () {
         check(user, epi_name, epi_num, rom_name, season);
      });
   });
});


var overlay = document.querySelector('#episodeOverlay');
var button = overlay.querySelector('.overlayCheck');
button.addEventListener('click', function () {
   var user = overlay.querySelector("input[name='user']").value;
   var epi_name = overlay.querySelector("#title").textContent;
   var epi_num = overlay.querySelector("input[name='epi_num']").value;
   var rom_name = overlay.querySelector("input[name='anime_name']").value;
   var season = overlay.querySelector("input[name='anime_season']").value;

   check(user, epi_name, epi_num, rom_name, season);
});

function check(user, epi_name, epi_num, rom_name, season) {
   var data = {
      user: user,
      epi_num: epi_num,
      rom_name: rom_name,
      season: season
   };
   
   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/epiCheck.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         var button = document.querySelector('.overlayCheck');
         button.classList.toggle('unchecked');
         button.classList.toggle('checked');
         
         var epi = document.querySelectorAll('.episode');
         epi.forEach(function (div) {
            var name = div.querySelector("h3").textContent;
            var button = div.querySelector('.checkbox-btn');

            if (name === epi_name) {
               button.classList.toggle('unchecked');
               button.classList.toggle('checked');
            }
         });
      }
   };
   xhr.send(JSON.stringify(data));
}