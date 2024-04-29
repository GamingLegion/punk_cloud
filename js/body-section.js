// JavaScript Document
const buttons = document.querySelectorAll('.body-section button');

buttons.forEach(button => {
   button.addEventListener('click', () => {
      buttons.forEach(btn => {
         btn.disabled = false;
         btn.style.backgroundColor = 'transparent';
         btn.style.boxShadow = '0 0px 0px rgba(0, 0, 0, 0.0)';
      });

      button.disabled = true;
      button.style.backgroundColor = '#51406B';
      button.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.75)';
   });
});
