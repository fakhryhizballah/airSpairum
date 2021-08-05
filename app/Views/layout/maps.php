<!DOCTYPE html>
<html>

<head>
    <title>Custom Legend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html,

        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>


    <script>
        var map;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: new google.maps.LatLng(-0.024909, 109.328319),
                mapTypeId: 'roadmap'
            });


            var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
            var icons = {
                parking: {
                    name: 'Parking',
                    icon: iconBase + 'parking_lot_maps.png'
                },
                library: {
                    name: 'Library',
                    icon: iconBase + 'library_maps.png'
                },
                info: {
                    name: 'Info',
                    icon: iconBase + 'info-i_maps.png'
                }
            };

            var features = [{
                position: new google.maps.LatLng(-0.026020, 109.332150),
                type: 'info'
            }, ];

            // Create markers.
            features.forEach(function(feature) {
                var marker = new google.maps.Marker({
                    position: feature.position,
                    icon: icons[feature.type].icon,
                    map: map
                });
            });

            var legend = document.getElementById('legend');
            for (var key in icons) {
                var type = icons[key];
                var name = type.name;
                var icon = type.icon;
                var div = document.createElement('div');
                div.innerHTML = '<img src="' + icon + '"> ' + name;
                legend.appendChild(div);
            }

            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-kQTsiZykwdlFQjzQvRYAuZAEMXjzoo8&callback=initMap">
    </script>
</body>

</html>