<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="Mandor/materializeicon/material-icons.css">
    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!-- <link href="/Mandor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <<link rel="stylesheet" href="Mandor/swiper/css/swiper-bundle.css" />

    <!-- Custom styles for this template -->
    <link href="css/home_style.css" rel="stylesheet">

    <!-- my style.css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- scanner -->
    <!-- <script src="/scanner/vendor/modernizr/modernizr.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="/scanner/vendor/vue/vue.min.js"></script>
    <title><?= $title; ?></title>
</head>

<body>

    <div class="wrapper homepage">

        <!-- header -->
        <div class="header">
            <div class="card fixed-top">
                <div class="row no-gutters">
                    <div class="col-1">
                        <!-- <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i></button> -->
                    </div>
                    <div class="col text-center"><img src="img/spairum logo.png" alt="" class="header-logo"></div>
                    <div class="col-11">
                        <!-- <a href="notification.html" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- header ends -->
        <div class="swal" data-swal="<?= session()->getFlashdata('gagal'); ?>"></div>
        <div class="flash-Success" data-flashdata="<?= session()->getFlashdata('Berhasil'); ?>"></div>

        <div class="camera">
            <video id="preview" class="kamera"></video>
        </div>

        <form action="user/binding" method="POST" id="myForm" class="user">
            <?= csrf_field(); ?>
            <div class="container">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="code" name="qrcode">
                </div>
            </div>
            <!-- <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Form Scan </legend>
                <input type="text" name="qrcode" id="code" autofocus>
            </fieldset> -->
        </form>



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


        <!-- jquery, popper and bootstrap js -->
        <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <!-- <script src="js/popper.min.js"></script> -->
        <!-- <script src="/Mandor/bootstrap-4.4.1/js/bootstrap.min.js"></script> -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <!-- swiper js -->
        <!-- <script src="/Mandor/swiper/js/swiper.min.js"></script> -->
        <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>

        <!-- cookie js -->
        <script src="/Mandor/cookie/jquery.cookie.js"></script>

        <!-- template custom js -->
        <script src="js/main.js"></script>

        <!-- page level script -->
        <script></script>
        <!-- scanner -->
        <!-- <script src="/scanner/js/app.js"></script> -->
        <script src="/scanner/vendor/instascan/instascan.min.js"></script>
        <script src="/scanner/js/scanner.js"></script>
        <!-- sweet alernt -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.7/sweetalert2.js"></script>
        <script src="js/script.js"></script>
</body>

</html>