<!doctype html>
<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- my style.css -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <!-- <meta http-equiv="refresh" content="10"> -->
    <!-- Manifes -->
    <link rel="manifest" href="Manifes/manifes.json">
    <meta name="theme-color" content="#2196f3">

    <style>
        #map {
            height: 100%;
            width: 100%;
            margin-top: 54px;
            position: fixed;
        }
    </style>
</head>
<title><?= $title; ?></title>

<body>

    <?= $this->renderSection('content'); ?>

    <!-- footer-->
    <div class="foother">
        <div class="no-gutters">
            <nav class="nav nav-pills nav-fill fixed-bottom bg-light">
                <div class="col-auto mx-auto">
                    <div class="row no-gutters justify-content-center">

                        <li class="nav-item col-auto">
                            <a href="/driver">
                                <img src="/img/Shape.png" alt="" class="buttonNav">
                                <a class="nav-link fontNav" href="/driver">Profil</a>
                            </a>
                        </li>
                        <li class="nav-item col-auto">
                            <a href="/explore">
                                <img src="/img/explore.png" alt="" class="buttonNav">
                                <a class="nav-link fontNav" href="/explore">Explore</a>
                            </a>
                        </li>
                        <li class="nav-item col-auto">
                            <a href="/history">
                                <img src="/img/riwayat.png" alt="" class="buttonNav">
                                <a class="nav-link fontNav">History</a>
                            </a>
                        </li>
                    </div>
                </div>
            </nav>

        </div>
    </div>
    <!-- footer ends-->


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function previewImg() {
            const profil = document.querySelector('#profil');
            const profilLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            profilLabel.textContent = profil.files[0].name;
            const fileProfil = new FileReader();

            fileProfil.readAsDataURL(profil.files[0]);

            fileProfil.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/script.js"></script>

</body>

</html>