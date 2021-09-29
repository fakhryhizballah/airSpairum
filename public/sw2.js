var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
    '/js/jquery-3.3.1.min.js',
    '/js/main.js',
    '/js/script.js',
    '/css/home_style.css',
    '/css/style.css',
    '/img/user/user.png',
    '/img/2.gif',
    '/img/spairum%20logo.png',
    '/img/infomarmation-graphics2.png',
    '/scanner/js/scanner.js',
    '/Manifes/manifes.json',
    'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/sweetalert2@9',
    'https://unpkg.com/swiper@7.0.6/swiper-bundle.js',
    'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
    'http://localhost:8080/Mandor/swiper/css/swiper-bundle.css',
    'https://unpkg.com/leaflet@1.6.0/dist/images/marker-icon-2x.png',
    'https://unpkg.com/leaflet@1.6.0/dist/images/marker-icon.png',
];

self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            console.log('Opened cache');
            return cache.addAll(urlsToCache);
        })
    );
});
self.addEventListener('fetch', function(event) {

    // event.respondWith(
    //     caches.match(event.request)
    //     .then(function(response) {
    //         // Cache hit - return response
    //         if (response) {
    //             return response;
    //         }
    //         return fetch(event.request);
    //     })
    // );
    event.respondWith(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.match(event.request).then(function(response) {
                return (
                    response ||
                    fetch(event.request).then(function(response) {
                        cache.put(event.request, response.clone());
                        return response;
                    })
                );
            });
        }),
    );
});


//activate service worker 
self.addEventListener('activate', event => {
    // delete any caches that aren't in expectedCaches
    // which will get rid of static-v1
    // event.waitUntil(
    //     caches.keys().then(keys => Promise.all(
    //         keys.map(key => {
    //             if (!expectedCaches.includes(key)) {
    //                 return caches.delete(key);
    //             }
    //         })
    //     )).then(() => {
    //         console.log('V2 now ready to handle fetches!');
    //     })
    // );
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.filter(function(cacheNames) {
                    return caches != CACHE_NAME
                }).map(function(cacheNames) {
                    return caches.delete(cacheNames)
                })
            );
        })
    );
});