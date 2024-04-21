// JavaScript Document
function openPopup(index) {
   document.querySelectorAll("#popupContainer")[index - 1].style.display = "block";
}

function closePopup(index) {
   document.querySelectorAll("#popupContainer")[index - 1].style.display = "none";
}

function optionSelected(option, index) {
   alert("Option " + option + " selected");
   closePopup(index);
}
