// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.
// var infoWindow;
// mapboxgl.accessToken = 'pk.eyJ1IjoiZmFraHJ5MSIsImEiOiJja3dlZmFvYzYwNDljMnBub3MwcjBxM2pnIn0.1Vtxn4u-dlSL7nHoFpb3Cw';
// var map = new mapboxgl.Map({
//     container: 'map',
//     style: 'mapbox://styles/mapbox/streets-v11'
// });
var map = L.map('map').fitWorld();
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    // L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZmFraHJ5MSIsImEiOiJja3dlZmFvYzYwNDljMnBub3MwcjBxM2pnIn0.1Vtxn4u-dlSL7nHoFpb3Cw', {
    // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
    //     '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    //     'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    // id: 'mapbox/satellite-v9',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(map);

map.locate({
    setView: true,
    maxZoom: 18,
    enableHighAccuracy: true,
});
map.getCenter();



var ikon = L.divIcon({
    className: 'custom-div-icon',
    html: "<div style='background-color:blue;' class='marker-pin'></div><img src='/img/user/user.png' alt='' class='marker-user' style='border-radius: 50px;'>",
    iconUrl: 'img/user/user.png',
    iconSize: [35, 35],
    watch: true,
    setView: true,
});
var Stasiun = L.icon({
    iconUrl: 'https://cdn.spairum.my.id/image/1655544826421-Stasiunspairum.png',
    iconSize: [35, 35],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});


function onLocationFound(e) {
    console.log(e);
    var akurat = parseInt(e.accuracy);
    console.log(akurat);
    L.marker(e.latlng, {
        icon: ikon
    }).addTo(map).bindPopup("lokasi Saya sekarang " + "<br />" + "accuracy GPS = " + akurat + " Meter");

    L.circle(e.latlng, {
        radius: akurat
    }).addTo(map);
};

// L.marker([-0.02487977307839744, 109.32841641147918]).addTo(map).bindPopup("<b>ss '>Buka Maps</a>");
// L.circle([-0.0393, 109.335], {
//     color: 'red',
//     fillColor: '#f03',
//     fillOpacity: 0.5,
//     radius: 500
// }).addTo(map);


function onLocationError(e) {
    alert(e.message);
    alert("Mohon izinkan akses lokasi");
}

map.on('locationfound', onLocationFound);
map.on('locationerror', onLocationError);

async function lokasiSpairum() {
    const response = await fetch('/maps/Maps', {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
    });
    console.log(response);
    const json = await response.json();
    console.log(json);
    for (let i = 0; i < json.length; i++) {
        var lat = json[i].geo.split(",")[0];
        var lng = json[i].geo.split(",")[1];
        var nama = json[i].nama;
        var alamat = json[i].alamat;
        var akurat = json[i].akurat;
        L.marker([lat, lng], {
            icon: Stasiun
        }).addTo(map).bindPopup("<b>" + json[i].nama + "</b>" + "<br />" + json[i].alamat);
    }
    // for (let i = 0; i < json.length; i++) {
    //     // console.log(json[i].lat);
    //     L.marker([json[i].lat, json[i].lng]).addTo(map).bindPopup("<b>" + json[i].lokasi + "</b> <br/> Keterangan : " + json[i].ket + "</br> Sataus Stasiun = " + json[i].status + "<br>" + '<a href=' + json[i].link + '>Buka Maps</a>');
    // }

    const response2 = await fetch('https://api.mapbox.com/directions/v5/mapbox/driving/-0.02487977307839744,109.32841641147918;-0.029548147949472487,109.32880010069258?access_token=pk.eyJ1IjoiZmFraHJ5MSIsImEiOiJja3dlZmFvYzYwNDljMnBub3MwcjBxM2pnIn0.1Vtxn4u-dlSL7nHoFpb3Cw', {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        z: {},
    });
    console.log(response2);
    const json2 = await response2.json();
    console.log(json2);
};
lokasiSpairum();

// L.geoJSON(data, {
//     style: function (feature) {
//         return { color: feature.properties.color };
//     }
// }).bindPopup(function (layer) {
//     return layer.feature.properties.description;
// }).addTo(map);