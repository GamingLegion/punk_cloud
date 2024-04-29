// JavaScript Document
document.addEventListener('DOMContentLoaded', function () {
   const buttons = document.querySelectorAll('.body-section button');
   const sections = document.querySelector('div.anime-body').querySelectorAll('.section');
   buttons.forEach(button => {
      button.addEventListener('click', () => {
         buttons.forEach(btn => {
            btn.disabled = false;
         });
         button.disabled = true;
         sections.forEach(function (sec) {
            if (!sec.classList.contains(button.id)) {
               sec.style.display = 'none';
            } else {
               sec.style.display = 'block';
            }
         });
      });
   });
});
