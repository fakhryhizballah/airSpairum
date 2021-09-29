const staticCacheName = 'site-static';
const assets = [
    '/js/script.js',
    '/js/main.js',
    '/js/statics.js',
    '/css/style.css',
    '/css/home_style.css',
    '/css/sb-admin-2.css',
    '/img/user/user.png',
    '/img/logo.png',
    'img/2.gif',
    'Manifes/img/logo.png',
    'Manifes/manifes.json'
];

// install service worker
self.addEventListener('install', evt => {
    console.log('service worker has been installed');
    evt.waitUntil(
        caches.open(staticCacheName).then(function(cache) {
            cache.addAll(assets);
        })
    );
});

//activate service worker 
self.addEventListener('activate', evt => {
    // console.log('service worker has been activate');
});

// fetch event
self.addEventListener('fetch', evt => {
    // console.log('fetch event', evt);
});