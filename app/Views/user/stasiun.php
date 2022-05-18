<html lang="id, in">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Material design icons CSS -->
    <!-- <link rel="stylesheet" href="Mandor/materializeicon/material-icons.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!-- <link href="Mandor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">


    <!-- my style.css -->
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Manifes -->
    <link rel="manifest" href="Manifes/manifes.json">
    <meta name="theme-color" content="#2196f3">
    <!-- <link rel="manifest" href="https://goo.gl/aESk5L"> -->

    <!-- Custom styles for this template -->
    <link href="css/home_style.css" rel="stylesheet">
    <link href="css/maps.css" rel="stylesheet">

    <!-- leaflet -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" /> -->
    <!-- <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css' rel='stylesheet' />

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-30Q4MD7E15"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-30Q4MD7E15');
    </script>

</head>
<title><?= $title; ?></title>

<body>
    <div class="wrapper">
        <!-- header -->
        <div class="header active">
            <div class="card fixed-top">
                <div class="row no-gutters">
                    <div class="col text-center"><img src="img/spairum logo.png" alt="" class="header-logo"></div>
                </div>
            </div>
        </div>
        <!-- header ends -->

        <div class="map">

            <div id="map"></div>
        </div>
        <!-- <div class="container">
            <!-- <div class="card shadow mt-4 h-200 overflow-hidden">
            </div> -->
    </div> -->



    <!-- footer-->
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
    </div>
    <script src=/js/maps.js></script>
    <!-- <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjKeVFWsG5gTOd4UegCxqJgKoRam9yJX0&callback=initMap"> </script> -->

    <!-- jquery, popper and bootstrap js -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- swiper js -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- cookie js -->
    <!-- <script src="Mandor/cookie/jquery.cookie.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

    <!-- template custom js -->
    <script src="js/main.js"></script>
    <script src="js/script.js"></script>

    <!-- page level script -->
    <script>
        // $(window).on('load', function() {

        // });
    </script>


</body>

</html>