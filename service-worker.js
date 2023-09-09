importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

workbox.precaching.precacheAndRoute([
  { "revision": "133cb6ccde559821aa7b1fa541dd43c5", "url": "offline.html" },
]);

const staticCacheName = 'static-assets-v1';
const dynamicCacheName = 'dynamic-assets-v1';

workbox.routing.registerRoute(
  /\.(?:js|css|png|gif|jpg|svg)$/,
  new workbox.strategies.CacheFirst({
    cacheName: staticCacheName,
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 50
      }),
    ],
  }),
);

workbox.routing.registerRoute(
  ({ event }) => event.request.mode === 'navigate',
  new workbox.strategies.NetworkFirst({
    cacheName: dynamicCacheName,
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 50
      }),
      new workbox.cacheableResponse.Plugin({
        statuses: [200]
      })
    ],
  }),
);

const FALLBACK_URL = workbox.precaching.getCacheKeyForURL('offline.html');
const navigationMatcher = ({ event }) => event.request.mode === 'navigate';
const navigationHandler = args =>
  workbox.strategies.networkFirst(args)
    .then(response => response || caches.match(FALLBACK_URL))
    .catch(() => caches.match(FALLBACK_URL));

workbox.routing.registerRoute(navigationMatcher, navigationHandler);
