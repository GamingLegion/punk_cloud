// JavaScript Document
var collapsibles = document.querySelectorAll('#collapsible');
collapsibles.forEach(function (div, index) {
   var season = div.querySelector('input').value;
   var sectBtn = document.querySelectorAll('#sectionCheck')[index];
   var epis = div.querySelectorAll('.episode-info');

   sectBtn.onclick = function () {
      epis.forEach(function (epi) {
         var user = epi.querySelectorAll("input")[0].value;
         var epi_name = epi.querySelector("h3").textContent;
         var epi_num = epi.querySelectorAll("input")[1].value;
         var rom_name = epi.querySelectorAll("input")[2].value;
         setTimeout(check(user, epi_name, epi_num, rom_name, season), index * 25);
      });

      // Toggle class for section checkbox
      if (sectBtn.classList.contains('unchecked')) {
         sectBtn.classList.remove('unchecked');
         sectBtn.classList.add('checked');
      } else {
         sectBtn.classList.remove('checked');
         sectBtn.classList.add('unchecked');
      }
   };

   epis.forEach(function (div2) {
      var user = div2.querySelectorAll("input")[0].value;
      var epi_name = div2.querySelector("h3").textContent;
      var epi_num = div2.querySelectorAll("input")[1].value;
      var rom_name = div2.querySelectorAll("input")[2].value;
      var button = div2.querySelector('button');
      button.onclick = function () {
         check(user, epi_name, epi_num, rom_name, season);
      };
   });
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
         var epi = document.querySelectorAll('.episode-info');
         epi.forEach(function (div) {
            var en = div.querySelector("h3").textContent;
            var button = div.querySelector('button');

            if (en === epi_name) {
               if (button.classList.contains('unchecked')) {
                  button.classList.remove('unchecked');
                  button.classList.add('checked');
               } else {
                  button.classList.remove('checked');
                  button.classList.add('unchecked');
               }
            }
         });
      }
   };
   xhr.send(JSON.stringify(data));
}
