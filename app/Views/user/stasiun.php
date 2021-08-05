<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="Mandor/materializeicon/material-icons.css">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!-- <link href="Mandor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">


    <!-- my style.css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Manifes -->
    <link rel="manifest" href="Manifes/manifes.json">
    <meta name="theme-color" content="#2196f3">
    <!-- <link rel="manifest" href="https://goo.gl/aESk5L"> -->

    <!-- Custom styles for this template -->
    <link href="css/home_style.css" rel="stylesheet">

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>





    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
            width: 100%;
            margin-top: 53px;
            /* margin-bottom: 54px; */
            position: fixed;

        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .marker-pin {
            width: 40px;
            height: 40px;
            border-radius: 50% 50% 50% 0;
            position: absolute;
            transform: rotate(-45deg);
            left: 50%;
            top: 50%;
            margin: -15px 0 0 -15px;
        }

        .marker-user {
            width: 30px;
            height: 30px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -10px 0 0 -10px;
        }

        /* to draw white circle */
        /* .marker-pin::after {
            content: '';
            width: 24px;
            height: 24px;
            margin: 3px 0 0 3px;
            background: #fff;
            position: absolute;
            border-radius: 50%;
        } */

        /* to align icon */
        .custom-div-icon i {
            position: absolute;
            width: 22px;
            font-size: 22px;
            left: 0;
            right: 0;
            margin: 10px auto;
            text-align: center;
        }

        #tabel_markers {
            position: fixed;
            top: 50%;
            left: 2%;
            overflow-y: auto;
            max-height: 300px;
            max-width: 500px;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            background-color: #f2f2f2;
            font-size: 9pt
        }

        #tabel_markers td,
        #tabel_markers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #tabel_markers tr:hover {
            background-color: #ddd;
        }

        #tabel_markers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<title><?= $title; ?></title>

<body>
    <!-- header -->
    <div class="header">
        <div class="card fixed-top">
            <div class="row no-gutters">
                <div class="col text-center"><img src="img/spairum logo.png" alt="" class="header-logo"></div>
            </div>
        </div>
    </div>
    <!-- header ends -->
    <div class="footer">
        <div class="no-gutters">
            <div class="col-auto mx-auto">
                <div class="row no-gutters justify-content-center">
                    <div class=" col-3-auto mx-auto">
                        <a href="/user" class="btn btn-link-default item">
                            <i class="material-icons">home</i>
                        </a>
                    </div>
                    <div class="col-3-auto mx-auto">
                        <a href="/stasiun" class="btn btn-link-default item">
                            <!-- <img src="/img/explore.svg" alt="" class=""> -->
                            <i class="material-icons">near_me</i>
                            <!-- <i class="fontNav">Explore</i> -->
                        </a>
                    </div>
                    <div class="col-3-auto mx-auto">
                        <a href="/topup" class="btn btn-link-default item">
                            <!-- <img src="/img/wallet.svg" alt="" class=""> -->
                            <i class="material-icons">account_balance_wallet</i>
                            <!-- <i class="fontNav">Top Up</i> -->
                        </a>
                    </div>
                    <div class="col-3-auto mx-auto">
                        <a href="/riwayat" class="btn btn-link-default item">
                            <!-- <img src="/img/history.svg" alt="" class=""> -->
                            <i class="material-icons">history</i>
                            <!-- <i class="material-icons fontNav">History</i> -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer ends-->
    <div class="map"></div>
    <div id="map"></div>

    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var infoWindow;
        // <div id="mapid" style="width: 600px; height: 400px;"></div>
        var map = L.map('map').fitWorld();
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {

            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(map);
        var ikon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:blue;' class='marker-pin'></div><img src='/img/user/<?= $akun["profil"]; ?>' alt='' class='marker-user' style='border-radius: 50px;'>",
            iconUrl: 'img/user/<?= $akun["profil"]; ?>',
            iconSize: [35, 35],

        });

        <?php foreach ($stasiun as $key => $value) { ?>
            L.marker([<?= $value['lat']; ?>, <?= $value['lng']; ?>]).addTo(map).bindPopup("<b><?= $value['lokasi']; ?></b><br /><?= $value['ket']; ?>. <br><a href='<?= $value['link']; ?> '>Buka Maps</a>");
        <?php } ?>

        function onLocationFound(e) {


            L.marker(e.latlng, {
                icon: ikon
            }).addTo(map);

            L.circle(e.latlng, radius).addTo(map);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({
            setView: true,
            maxZoom: 16
        });
    </script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjKeVFWsG5gTOd4UegCxqJgKoRam9yJX0&callback=initMap">
    </script>





    <!-- jquery, popper and bootstrap js -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- swiper js -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- cookie js -->
    <script src="Mandor/cookie/jquery.cookie.js"></script>

    <!-- template custom js -->
    <script src="js/main.js"></script>
    <script src="js/script.js"></script>

    <!-- page level script -->
    <script>
        $(window).on('load', function() {

        });
    </script>


</body>

</html>