
import VenoBox from '../libs/venobox/dist/venobox.min.js';

document.addEventListener('DOMContentLoaded', function() {

   new VenoBox({
      selector: '.image-popup',
      infinigall: true,
   });

   new VenoBox({
      selector: '.gallery-icon a',
      infinigall: true,
   });

   new VenoBox({
      selector: '.js-var',
   });


})