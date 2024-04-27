//JavaScript Document
var infoLines = document.querySelectorAll('.info_line');
infoLines.forEach(function (infoLine) {
   var firstParagraph = infoLine.querySelector('a');
   var secondParagraph = infoLine.querySelector('.info');
   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for ' + firstParagraph.textContent, secondParagraph.textContent);
      if (newValue !== null) {
         updateField(secondParagraph, secondParagraph.id, secondParagraph.dataset.season,  newValue);
      }
   };

   infoLine.insertBefore(editButton, firstParagraph);
});
var collapses = document.querySelectorAll(".collapsible");
collapses.forEach(function(collapse) {
   var imgDiv = collapse.querySelector(".imgDiv");
   var img = imgDiv.querySelector("img");
   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for image path');
      if (newValue !== null) {
         updateField(img, "image", img.dataset.season,  newValue);
      }
   };

   imgDiv.insertBefore(editButton, img);
});

function updateField(line, fieldName, season, newValue) {
   var name = window.location.href;
   name = decodeURIComponent(name);
   name = name.substring(name.lastIndexOf('=') + 1);

   var data = {
      name: name,
      season: season,
      field: fieldName,
      value: newValue
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/editAnime.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         if(fieldName === "image") {
            line.src = "http://localhost/PunkCloud/images/arts/anime/" + newValue;
         } else {
            line.textContent = newValue;
         }
      }
   };
   xhr.send(JSON.stringify(data));
}
