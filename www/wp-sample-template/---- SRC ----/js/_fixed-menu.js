
// скрипт плавающего меню
document.addEventListener('DOMContentLoaded', function() {
   if (document.querySelector('.topmenu--fixed')) {
      document.addEventListener('scroll', function() {
         const navbar = document.querySelector('.topmenu--fixed');
         const scrollPosition = window.scrollY;

         if (scrollPosition > 500) { // Пороговое значение для появления меню
            navbar.classList.remove('topmenu--fixed__top');
            setTimeout(() => navbar.classList.add('topmenu--fixed__visible'), 500);
         } else {
            setTimeout(() => navbar.classList.remove('topmenu--fixed__visible'), 500);
            navbar.classList.add('topmenu--fixed__top');
         }
      });
   }
});