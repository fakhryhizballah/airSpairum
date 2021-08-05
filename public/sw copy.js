var CACHE_NAME = 'my_cace_spairum_v1';
var urlsToCache = [
    '/',
    '/img/logo.png',
    '/img/2.gif',
    '/css/style.css',
    '/css/home_style.css',
    '/css/home_style.css',
    '/js/main.js',
    '/js/script.js',

]
self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
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
    btnAdd.style.display = 'block';
    showInstallPromotion();
});

btnAdd.addEventListener('click', (e) =>{
    deferredPrompt.prompt();
    deferredPrompt.useChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the A2HS prompt');
        }
        deferredPrompt = null;
    });
});

window.addEventListener('appinstalled', (evt) => {
    app.logEvent('a2hs', 'installed');
});