self.addEventListener('install', function(e) {
  console.log('Service Worker: Installed');
  e.waitUntil(
    caches.open('mnotas-cache').then(function(cache) {
      return cache.addAll([
        '/',
        '/css/app.css',
        '/js/app.js',
        '/icons/icon-192x192.png'
      ]);
    })
  );
});

self.addEventListener('fetch', function(e) {
  e.respondWith(
    caches.match(e.request).then(function(response) {
      return response || fetch(e.request);
    })
  );
});
