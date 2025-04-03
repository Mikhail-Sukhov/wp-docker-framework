function toggleFloatingButtons() {
   const floatingButtons = document.getElementById('floatingButtons');
   floatingButtons.classList.toggle('sticky-contact__buttons--active');

   const buttons = floatingButtons.querySelectorAll('.sticky-contact__button');
   buttons.forEach((button, index) => {
      if (
         floatingButtons.classList.contains('sticky-contact__buttons--active')
      ) {
         button.style.transform = `translateY(-${(index + 1) * 80}px)`;
      } else {
         button.style.transform = 'translateY(0)';
      }
   });
}
