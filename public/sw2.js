var CACHE_NAME = 'my-site-cache-v2';
var urlsToCache = [
    '/js/main.js',
    '/js/script.js',
    '/css/home_style.css',
    '/css/style.css',
    '/img/user/user.png',
    '/img/spairum%20logo.png',
    '/img/infomarmation-graphics2.png',
    '/scanner/js/scanner.js',
    '/Manifes/manifes.json',
    'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/css/swiper.min.css',

    'https://unpkg.com/leaflet@1.6.0/dist/images/marker-icon-2x.png',
    'https://unpkg.com/leaflet@1.6.0/dist/images/marker-icon.png',
];

self.addEventListener('install', function(event) {
    // Perform install steps
    console.log("SW Install");
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            console.log('Opened cache');
            return cache.addAll(urlsToCache);
        })
    );
});
self.addEventListener('fetch', function(event) {

    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                // Cache hit - return response
                if (response) {
                    return response;
            }
            return fetch(event.request);
        })
    );
    console.log("SW fecth");
    const url = new URL(event.request.url);
    console.log(event.request);
    // event.respondWith(
    //     caches.open(CACHE_NAME).then(function(cache) {
    //         return cache.match(event.request).then(function(response) {
    //             return (
    //                 response ||
    //                 fetch(event.request).then(function(response) {
    //                     cache.put(event.request, response.clone());
    //                     return response;
    //                 })
    //             );
    //         });
    //     }),
    // );
});


//activate service worker 
self.addEventListener('activate', event => {
    console.log("SW activate now ready to handle fetches!");
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