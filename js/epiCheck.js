// JavaScript Document
var episodes = document.querySelectorAll('.episode-info');
episodes.forEach(function (div) {
   var user = div.querySelectorAll("input")[0].value;
   var epi_name = div.querySelector("h3").textContent;
   var epi_num = div.querySelectorAll("input")[1].value;
   var rom_name = div.querySelectorAll("input")[2].value;
   var season = div.querySelectorAll("input")[3].value;
   var button = div.querySelector('button');
   button.onclick = function () {
      check(user, epi_name, epi_num, rom_name, season);
   };
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
