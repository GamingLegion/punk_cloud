// JavaScript Document
document.addEventListener('DOMContentLoaded', function () {
   const buttons = document.querySelectorAll('.body-section button');
   const sections = document.querySelector('div.anime-body').querySelectorAll('.section');
   buttons.forEach(button => {
      button.addEventListener('click', () => {
         buttons.forEach(btn => {
            btn.disabled = false;
            btn.style.backgroundColor = 'transparent';
            btn.style.boxShadow = '0 0px 0px rgba(0, 0, 0, 0.0)';
         });
         sections.forEach(function (sec) {
            if (!sec.classList.contains(button.id)) {
               sec.style.display = 'none';
            } else {
               sec.style.display = 'block';
            }
         });

         button.disabled = true;
         button.style.backgroundColor = '#51406B';
         button.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.75)';
      });
   });
});
