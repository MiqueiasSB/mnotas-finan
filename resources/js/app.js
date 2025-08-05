import './bootstrap';
//import 'bootswatch/dist/flatly/bootstrap.css';
import './jquery.maskMoney';
import './logica';
import 'animate.css';
import Alpine from 'alpinejs'
import mask from '@alpinejs/mask'
Alpine.plugin(mask)
import intersect from '@alpinejs/intersect'
Alpine.plugin(intersect)

if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
    navigator.serviceWorker.register('/sw.js')
      .then(function (registration) {
        console.log('Service Worker registrado com sucesso:', registration);
      }, function (err) {
        console.log('Falha ao registrar o Service Worker:', err);
      });
  });
}



//Alpine.start()
