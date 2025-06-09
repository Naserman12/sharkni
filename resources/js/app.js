
import 'alpinejs';
// var Turbolinks = require("turbolinks")
// Turbolinks.start()

 document.getElementById('menu-toggle').addEventListener('click', function(){
                const menu = document.getElementById('menu');
                menu.classList.toggle('hidden');
});

// الفلترة
// function filterComponent() {
//   return {
//     isOpen: false,

//     init() {
//       const savedState = localStorage.getItem('filtersOpen');
//       this.isOpen = savedState === 'true';
//     },

//     toggle() {
//       this.isOpen = !this.isOpen;
//       localStorage.setItem('filtersOpen', this.isOpen);
//     }
//   }
// }