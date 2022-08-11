mapboxgl.accessToken = 'pk.eyJ1IjoiZmFraHJ5MSIsImEiOiJja3dlZmFvYzYwNDljMnBub3MwcjBxM2pnIn0.1Vtxn4u-dlSL7nHoFpb3Cw';

const map = new mapboxgl.Map({
    container: 'map',
    // style: 'mapbox://styles/mapbox/light-v10',
    style: 'mapbox://styles/mapbox/streets-v11', // style URL
    // style: 'mapbox://styles/mapbox/satellite-v9', // style URL
    minZoom: 9,
    maxZoom: 18,
    center: [109.331814, -0.026106],
    scrollZoom: true,
    // zoom: 1, // starting zoom
    // projection: 'globe' // display map as a 3D globe

});
// Add geolocate control to the map.
// map.addControl(
//     new mapboxgl.GeolocateControl({
//         positionOptions: {
//             enableHighAccuracy: true
//         },
//         // When active the map will receive updates to the device's location as it changes.
//         trackUserLocation: true,
//         // Draw an arrow next to the location dot to indicate which direction the device is heading.
//         showUserHeading: true
//     })
// );

// map.addControl(
//     new MapboxGeocoder({
//         accessToken: mapboxgl.accessToken,
//         mapboxgl: mapboxgl
//     })
// );
map.on('style.load', () => {
    map.setFog({}); // Set the default atmosphere style
});
// Initialize the GeolocateControl.
const geolocate = new mapboxgl.GeolocateControl({
    positionOptions: {
        enableHighAccuracy: true
    },
    trackUserLocation: true
});
// Add the control to the map.
map.addControl(geolocate);
// Set an event listener that fires
// when a geolocate event occurs.
geolocate.on('geolocate', () => {
    // console.log('A geolocate event has occurred.');
});


function tes() {
    const marker = new mapboxgl.Marker()
        .type("Feature")
        .setLngLat([109.331814, -0.026126])
        .addTo(map);
    new mapboxgl.Marker()
        .setLngLat([109.331314, -0.026106])
        .addTo(map);

    // const marker = new mapboxgl.Marker()
    //     .setLngLat([lngLat.lng, lngLat.lat])
    //     .addTo(map);
}

function rotate() {
    map.easeTo({
        bearing: 40,
        duration: 10000,
        pitch: 25,
        zoom: 15
    });
}

map.on('load', () => {

    rotate();
    geolocate.trigger();

    lokasiSpairum();
    banksampah();
});

async function lokasiSpairum() {
    const response = await fetch('/maps/Stasiun', {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
    });
    // console.log(response);
    const json = await response.json();
    // console.log(json);
    for (let i = 0; i < json.length; i++) {
        var lat = json[i].geo.split(",")[0];
        var lng = json[i].geo.split(",")[1];
        var nama = json[i].nama;
        var alamat;
        const el = document.createElement('div');
        var url = json[i].gmaps;
        alamat = "<a href='" + url + "'>Buka Maps</a>"

        el.className = 'marker';
        el.style.backgroundImage = `url(https://cdn.spairum.my.id/image/1655544826421-Stasiunspairum.png)`;
        el.style.width = '35px';
        el.style.height = `35px`;
        el.style.backgroundSize = '100%';

        // el.addEventListener('click', () => {
        //     window.alert(marker.properties.message);
        // });


        // Add markers to the map.
        new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .setPopup(new mapboxgl.Popup({
                offset: 25
            })
                .setHTML(
                    "<b>" + nama + "</b>" + "<br />" + json[i].keterangan + "<br />" + alamat + "<br />"
                )) // sets a popup on this marker
            .addTo(map);
    };
}
async function banksampah() {
    const response = await fetch('/maps/banksampah', {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
    });
    // console.log(response);
    const json = await response.json();
    // console.log(json);
    for (let i = 0; i < json.length; i++) {
        var lat = json[i].geo.split(",")[0];
        var lng = json[i].geo.split(",")[1];
        var nama = json[i].nama;
        var alamat;
        const el = document.createElement('div');
        var url = json[i].gmaps;
        alamat = "<a href='" + url + "'>Buka Maps</a>"

        el.className = 'marker';
        el.style.backgroundImage = `url(https://cdn.spairum.my.id/image/1655550652034-bank.png)`;
        el.style.width = '35px';
        el.style.height = `35px`;
        el.style.backgroundSize = '100%';

        // el.addEventListener('click', () => {
        //     window.alert(marker.properties.message);
        // });


        // Add markers to the map.
        new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .setPopup(new mapboxgl.Popup({
                offset: 25
            })
                .setHTML(
                    "<b>" + nama + "</b>" + "<br />" + json[i].keterangan + "<br />" + alamat + "<br />"
                )) // sets a popup on this marker
            .addTo(map);
    };
}