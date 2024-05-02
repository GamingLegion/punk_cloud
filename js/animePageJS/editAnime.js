//JavaScript Document
var infoLines = document.querySelector(".anime_header_info_wrapper").querySelectorAll('.info_line');
infoLines.forEach(function (infoLine) {
   var firstParagraph = infoLine.querySelector('a');
   var secondParagraph = infoLine.querySelector('.info');

   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for ' + firstParagraph.textContent, secondParagraph.textContent);
      if (newValue !== null) {
         updateField(0, secondParagraph, secondParagraph.id, 'all', newValue);
      }
   };

   infoLine.insertBefore(editButton, firstParagraph);
});
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
   var imgDiv = collapse.querySelector(".anime-image");
   var img = imgDiv.querySelector("img");

   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.style.position = 'absolute';
   editButton.style.zIndex = '999';
   editButton.onclick = function () {
      var newValue = prompt('Enter new value for image path', img.src);
      if (newValue !== null) {
         if(newValue.indexOf("http://") >= 0) {
            newValue = newValue.substr(newValue.lastIndexOf("/") + 1);
         }
         updateField(collapse, img, img.id, img.dataset.season, newValue);
      }
   };

   imgDiv.insertBefore(editButton, imgDiv.querySelector(".anime-image-sub"));
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
   } else if(collapse === 0) {
      collapses.forEach(function (col, index) {
         sN[index] = col.querySelector(".checkbox-btn").dataset.romname;
         sS[index] = col.querySelector(".season_name").textContent;
         lines[index] = 0;
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
         xhr.open('POST', '/PunkCloud/php/tools/editAnime.php', true);
         xhr.setRequestHeader('Content-Type', 'application/json');
         xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
               if(lines[i] !== 0) {
                  if (fieldName === "image") {
                     lines[i].src = "http://localhost/PunkCloud/images/arts/anime/" + newValue;
                  } else {
                     lines[i].textContent = newValue;
                  }
               } else {
                  line.textContent = newValue;
               }
            }
         };
         xhr.send(JSON.stringify(data));
      })(i);
   }
}
