

import '../libs/imask/dist/imask.min.js';
//import IMask from 'imask';

document.addEventListener('DOMContentLoaded', function() {

   const tel = document.getElementById('form__tel');

   if (tel) {

      IMask(tel, {
         mask: '+{7}(000)000-00-00',
         lazy: false,  // make placeholder always visible
         placeholderChar: '*'
      })
   }

})