//JavaScript Document
var infoLines = document.querySelectorAll('.info_line');
infoLines.forEach(function (infoLine) {
   var firstParagraph = infoLine.querySelector('a');
   var secondParagraph = infoLine.querySelectorAll('a')[1];
   var editButton = document.createElement('button');
   editButton.id = 'editBtn';
   editButton.textContent = 'Edit';
   editButton.onclick = function () {
      var newValue= prompt('Enter new value for ' + secondParagraph.id, secondParagraph.textContent);
         if (newValue !== null) {
            updateField(secondParagraph.id, newValue);
         }
   };

   infoLine.insertBefore(editButton, firstParagraph);
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