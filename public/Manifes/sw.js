var CACHE_NAME = 'my_cace_spairum_v1';
var urlsToCache = [
    '/',
    '/img/logo.png',
    '/js/script.js',
    '/img/Group%2013.png',
    '/img/Vector.png',
    '/img/ig_gS2_icon.ico',
    '/css/auth.css',
    '/sw.js'

]

self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(CACHE_NAME)

        .then(function(cache) {
            console.log('im install');
            return cache.addAll(urlsToCache);
        })
    );
});

self.addEventListener('activate', function(event) {
    console.log('Finally active. Ready to start serving content!');
});

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 76 and later from showing the mini-infobar
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    showInstallPromotion();
});