//JavaScript Document
var collapses = document.querySelectorAll(".collapsible");
collapses.forEach(function (collapse) {
   var infoLines = collapse.querySelectorAll('.info_line');
   infoLines.forEach(function (infoLine) {
      var firstParagraph = infoLine.querySelector('a');
      var secondParagraph = infoLine.querySelector('.info');

      var editButton = document.createElement('button');
      editButton.id = 'editBtn';
      editButton.textContent = 'Edit';
      editButton.onclick = function () {
         var newValue = prompt('Enter new value for ' + firstParagraph.textContent, secondParagraph.textContent);
         if (newValue !== null) {
            updateField(collapse, secondParagraph, secondParagraph.id, secondParagraph.dataset.season, newValue);
         }
      };

      infoLine.insertBefore(editButton, firstParagraph);
   });
});
collapses.forEach(function (collapse) {
   var imgDiv = collapse.querySelector(".imgDiv");
   var img = imgDiv.querySelector("img");

   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for image path');
      if (newValue !== null) {
         updateField(collapse, img, img.id, img.dataset.season, newValue);
      }
   };

   imgDiv.insertBefore(editButton, img);
});
collapses.forEach(function (collapse) {
   var btnWrap = collapse.querySelector(".collapsible-btn-wrapper");
   var txt = btnWrap.querySelector(".season_name");

   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for season/arc name', txt.textContent);
      if (newValue !== null) {
         updateField(collapse, txt, "season", txt.textContent, newValue);
      }
   };

   btnWrap.insertBefore(editButton, btnWrap.querySelector(".collapsible-btn"));
});

var seasons = document.querySelector(".seasons");
var col = document.querySelector(".collapsible");
var checkbox = document.createElement('input');
checkbox.type = 'checkbox';
seasons.insertBefore(checkbox, col);

function updateField(collapse, line, fieldName, season, newValue) {
   var sN = [];
   var sS = [];
   var lines = [];
   var cb = document.querySelector("input[type=checkbox]");
   
   if (cb.checked) {
      collapses.forEach(function (col, index) {
         sN[index] = col.querySelector(".checkbox-btn").dataset.romname;
         sS[index] = col.querySelector(".season_name").textContent;

         if (line.classList.contains("info")) {
            var infoLines = col.querySelectorAll('.info_line');
            infoLines.forEach(function (infoLine) {
               var secondParagraph = infoLine.querySelector('.info');
               if (secondParagraph.id === fieldName) {
                  lines[index] = secondParagraph;
               }
            });
         } else if (line.id === "image") {
            var imgDiv = col.querySelector(".imgDiv");
            lines[index] = imgDiv.querySelector("img");
         } else if (line.classList.contains("season_name")) {
            var btnWrap = collapse.querySelector(".collapsible-btn-wrapper");
            lines[index] = btnWrap.querySelector(".season_name");
         }
      });
   } else {
      sN[0] = collapse.querySelector(".checkbox-btn").dataset.romname;
      sS[0] = collapse.querySelector(".season_name").textContent;
      lines[0] = line;
   }
   
   for (var i = 0; i < lines.length; i++) {
      (function (i) {
         var data = {
            name: sN[i],
            season: sS[i],
            field: fieldName,
            value: newValue
         };

         var xhr = new XMLHttpRequest();
         xhr.open('POST', '../php/tools/editAnime.php', true);
         xhr.setRequestHeader('Content-Type', 'application/json');
         xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
               if (fieldName === "image") {
                  lines[i].src = "http://localhost/PunkCloud/images/arts/anime/" + newValue;
               } else {
                  lines[i].textContent = newValue;
               }
            }
         };
         xhr.send(JSON.stringify(data));
      })(i);
   }
}