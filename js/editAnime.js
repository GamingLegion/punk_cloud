//JavaScript Document
var infoLines = document.querySelectorAll('.info_line');
infoLines.forEach(function (infoLine) {
   var firstParagraph = infoLine.querySelector('p');
   var secondParagraph = infoLine.querySelectorAll('p')[1];
   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue;
      if (secondParagraph.id === 'height_ft') {
         newValue = prompt('Enter new value for ' + secondParagraph.id, '');
         if (newValue !== null) {
            updateField(secondParagraph.id, newValue);
         }
      } else {
         newValue = prompt('Enter new value for ' + secondParagraph.id, secondParagraph.textContent);
         if (newValue !== null) {
            updateField(secondParagraph.id, newValue);
         }
      }

      if (secondParagraph.id === 'height_ft' || secondParagraph.id === 'measurements_bust') {
         var thirdParagraph = infoLine.querySelectorAll('p')[2];
         newValue = prompt('Enter new value for ' + thirdParagraph.id, '');
         if (newValue !== null) {
            updateField(thirdParagraph.id, newValue);
         }
      }

      if (secondParagraph.id === 'measurements_bust') {
         var fourthParagraph = infoLine.querySelectorAll('p')[3];
         newValue = prompt('Enter new value for ' + fourthParagraph.id, '');
         if (newValue !== null) {
            updateField(fourthParagraph.id, newValue);
         }
      }
   };

   infoLine.insertBefore(editButton, firstParagraph);
});

var natiTits = document.querySelector('#nati_tit');
natiTits.addEventListener("click", function () {
   if (this.getAttribute('src') === "../images/icons/soa.png") {
      this.src = "../images/icons/no_soa.png";
      updateField('natural_tits', 0);
   } else {
      this.src = "../images/icons/soa.png";
      updateField('natural_tits', 1);
   }
});

var offWebs = document.querySelectorAll('.offWebs');
offWebs.forEach(function (div) {
   var header = div.querySelector('h2');
   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Add Site';
   editButton.onclick = function () {
      var newValue = prompt('Enter new site link');
      if (newValue !== null) {
         updateSites('sites', newValue);
      }
   };

   div.insertBefore(editButton, header);
});

function updateField(fieldName, newValue) {
   var name = window.location.href;
   name = decodeURIComponent(name);
   name = name.substring(name.lastIndexOf('=') + 1);

   var data = {
      name: name,
      field: fieldName,
      value: newValue
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/editModel.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         var field = document.getElementById(fieldName);
         if (fieldName === 'height_ft') {
            field.textContent = newValue + "'";
         } else if (fieldName === 'height_in') {
            field.textContent = newValue + '"';
         } else {
            field.textContent = newValue;
         }
      }
   };
   xhr.send(JSON.stringify(data));
}

function updateSites(fieldName, newValue) {
   var name = window.location.href;
   name = decodeURIComponent(name);
   name = name.substring(name.lastIndexOf('=') + 1);
   var data = {
      name: name,
      field: fieldName,
      value: newValue
   };

   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/editModelSites.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.send(JSON.stringify(data));
}
