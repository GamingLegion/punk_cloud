//JavaScript Document
var overlay = document.querySelectorAll("#episodeOverlay")
overlay.forEach(function (over) {
   var overlayImg = over.querySelector("#overlayImg");
   var title = over.querySelector("#titleLine");
   var relDate = over.querySelector("#episode-release-date");
   //var desc = over.querySelector("#description");

   var editBtn1 = document.createElement('button');
   editBtn1.id = 'editBtn';
   editBtn1.textContent = 'Edit Thumbnail';
   editBtn1.onclick = function () {
      var newValue = prompt('Enter new path for thumbnail', overlayImg.querySelector('img').src);
      if (newValue !== null) {
         updateOverField(title.querySelector('p').textContent, 'thumbnail', newValue, 'overlayImg', over.querySelectorAll("input"));
      }
   };
   over.insertBefore(editBtn1, overlayImg);

   var editBtn2 = document.createElement('button');
   editBtn2.id = 'editBtn';
   editBtn2.textContent = 'Edit';
   editBtn2.onclick = function () {
      var newValue = prompt('Enter new value for episode name', title.querySelector('p').textContent);
      if (newValue !== null) {
         updateOverField(title.querySelector('p').textContent, 'name', newValue, 'title', over.querySelectorAll("input"));
      }
   };
   over.insertBefore(editBtn2, title);

   var editBtn3 = document.createElement('button');
   editBtn3.id = 'editBtn';
   editBtn3.textContent = 'Edit';
   editBtn3.onclick = function () {
      var newValue = prompt('Enter new value for release date', relDate.querySelectorAll('p')[1].textContent);
      if (newValue !== null) {
         updateOverField(title.querySelector('p').textContent, 'release_date', newValue, 'release_date', over.querySelectorAll("input"));
      }
   };
   over.insertBefore(editBtn3, relDate);
});

function updateOverField(epiName, pmaColName, newValue, fieldName, inputs) {
   var data = {
      name: epiName,
      field: pmaColName,
      value: newValue,
      
      anime_name: inputs[0].value,
      anime_season: inputs[1].value,
      epi_num: inputs[2].value
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/editAnimeEpi.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         var field = document.getElementById(fieldName);
         if (fieldName === 'overlayImg') {
            field.querySelector('img').src = newValue;
         } else {
            field.textContent = newValue;
         }
      }
   };
   xhr.send(JSON.stringify(data));
}
