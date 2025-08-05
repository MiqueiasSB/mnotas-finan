self.addEventListener('install', function(e) {
  console.log('Service Worker: Installed');
  e.waitUntil(
    caches.open('mnotas-cache').then(function(cache) {
      return cache.addAll([
        '/home',              // cache da rota estável
        '/css/app.css',
        '/js/app.js',
        '/img/logo-192.png',
        '/img/logo-512.png'
      ]);
    })
  );
});

self.addEventListener('fetch', function(e) {
  e.respondWith(
    fetch(e.request).catch(() => {
      return caches.match(e.request);
    })
  );
});
