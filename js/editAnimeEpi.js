//JavaScript Document
var overlay = document.querySelector("#episodeOverlay")
var img = overlay.querySelector("#overlayImg");
var title = overlay.querySelector("#titleLine");
var relDate = overlay.querySelector("#episode-release-date");
//var desc = over.querySelector("#description");

var epiName = title.querySelector('p').textContent;
var checkbox = title.querySelector(".checkbox-btn");

var editBtn1 = document.createElement('button');
editBtn1.id = 'editBtn';
editBtn1.textContent = 'Edit Thumbnail';
editBtn1.onclick = function () {
   var newValue = prompt('Enter new path for thumbnail', img.querySelector('img').src);
   if (newValue !== null) {
      updateOverField(epiName, 'thumbnail', newValue, 'overlayImg', checkbox);
   }
};
overlay.insertBefore(editBtn1, img);

var editBtn2 = document.createElement('button');
editBtn2.id = 'editBtn';
editBtn2.textContent = 'Edit Title';
editBtn2.onclick = function () {
   var newValue = prompt('Enter new value for episode name', epiName);
   if (newValue !== null) {
      updateOverField(epiName, 'name', newValue, 'title', checkbox);
   }
};
overlay.insertBefore(editBtn2, title);

var editBtn3 = document.createElement('button');
editBtn3.id = 'editBtn';
editBtn3.textContent = 'Edit Release Date';
editBtn3.onclick = function () {
   var newValue = prompt('Enter new value for release date', relDate.querySelectorAll('p')[1].textContent);
   if (newValue !== null) {
      updateOverField(epiName, 'release_date', newValue, 'release_date', checkbox);
   }
};
overlay.insertBefore(editBtn3, relDate);


function updateOverField(epiName, pmaColName, newValue, fieldName, button) {
   var data = {
      name: epiName,
      field: pmaColName,
      value: newValue,

      anime_name: button.dataset.romname,
      anime_season: button.dataset.season,
      epi_num: button.dataset.epinum
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
