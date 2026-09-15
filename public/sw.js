// Wengel for World PWA Service Worker
self.addEventListener('install', (e) => {
  self.skipWaiting();
});

self.addEventListener('activate', (e) => {
  console.log('Wengel PWA Service Worker Active');
});

self.addEventListener('fetch', (e) => {
  // Let the browser do its normal network fetch
});
