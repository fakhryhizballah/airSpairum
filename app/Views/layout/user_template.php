<!doctype html>

<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="google" content="notranslate" />

    <!-- Material design icons CSS -->
    <!-- <link rel="stylesheet" href="vendor/materializeicon/material-icons.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!-- <link href="Mandor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" /> -->
    <!-- <link href="Mandor/swiper/css/swiper.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="/Mandor/swiper/css/swiper-bundle.css" />
    <!-- <link rel="stylesheet" href="Mandor/swiper/css/swiper-bundle.min.css" /> -->

    <!-- my style.css -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Manifes -->
    <link rel="manifest" href="/Manifes/manifes.json">
    <meta name="theme-color" content="#2196f3">


    <!-- Custom styles for this template -->
    <link href="/css/home_style.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-30Q4MD7E15"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-30Q4MD7E15');
    </script>
    <?= $this->renderSection('head'); ?>

</head>
<title><?= $title; ?></title>


<body>

    <div class="preloader">
        <div class="loading">
            <img src="/img/2.gif" width="100%">
        </div>
    </div>
    <div class="sidebar">
        <div class="mt-4 mb-3">
            <div class="row">
                <div class="col-auto">
                    <figure class="avatar avatar-60 border-0"><img src="/img/user/<?= $akun['profil']; ?>" alt=""></figure>
                </div>
                <div class="col pl-0 align-self-center">
                    <h5 class="mb-1"><?= $akun['nama_depan']; ?>&nbsp;<?= $akun['nama_belakang']; ?></h5>
                    <p class="text-mute small">Username : <?= $akun['nama']; ?> <br> ID : <?= $akun['id_user']; ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="list-group main-menu">
                    <a href="/user" class="list-group-item list-group-item-action active"><i class="material-icons icons-raised">home</i>Home</a>

                    <!-- <a href="notification.html" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">notifications</i>Notification <span class="badge badge-dark text-white">2</span></a> -->

                    <a href="/riwayat" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">find_in_page</i>History</a>
                    <!-- <a href="controls.html" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">view_quilt<span class="new-notification"></span></i>Pages Controls</a> -->
                    <a href="/editprofile" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">account_circle</i>Edit Profile</a>
                    <a href="/changepassword" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">vpn_key</i>Change Password</a>
                    <!-- <a href="#" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">important_devices</i>Settings</a> -->
                    <!-- <a href="javascript:void(0)" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#colorscheme"><i class="material-icons icons-raised">color_lens</i>Color scheme</a> -->
                    <!-- <a href="javascript:void(0)" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#colorscheme"><i class="material-icons icons-raised">color_lens</i>Color scheme</a> -->
                    <a href="/auth/logout" class="list-group-item list-group-item-action"><i class="material-icons icons-raised bg-danger">power_settings_new</i>Logout</a>

                </div>
            </div>
        </div>
    </div>
    <!-- color chooser menu start -->
    <div class="modal fade " id="colorscheme" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header theme-header border-0">
                    <h6 class="">Color Picker</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center theme-color">
                        <button class="m-1 btn red-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="red-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn blue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="blue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn yellow-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="yellow-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn green-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="green-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn pink-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="pink-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn orange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="orange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn purple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="purple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeppurple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeppurple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lightblue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lightblue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn teal-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="teal-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lime-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lime-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeporange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeporange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn gray-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="gray-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn black-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="black-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-6 text-left">
                        <div class="row">
                            <div class="col-auto text-right align-self-center"><i class="material-icons text-warning vm">wb_sunny</i></div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="themelayout" class="custom-control-input" id="theme-dark">
                                    <label class="custom-control-label" for="theme-dark"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center"><i class="material-icons text-dark vm">brightness_2</i></div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-auto text-right align-self-center">LTR</div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="rtllayout" class="custom-control-input" id="theme-rtl">
                                    <label class="custom-control-label" for="theme-rtl"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center">RTL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- color chooser menu ends -->

    <a href="javascript:void(0)" class="closesidemenu"><i class="material-icons icons-raised bg-dark ">close</i></a>
    <div class="wrapper homepage">

        <!-- header -->
        <div class="header">
            <div class="card fixed-top">
                <div class="row no-gutters">
                    <div class="col-1">
                        <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">more_horiz</i></button>
                    </div>
                    <div class="col text-center"><img src="/img/spairum logo.png" alt="" class="header-logo"></div>
                    <div class="col-11">
                        <!-- <a href="notification.html" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- header ends -->


        <?= $this->renderSection('content'); ?>

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

    <?= $this->renderSection('modal'); ?>



    <!-- jquery, popper and bootstrap js -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="Mandor/bootstrap-4.4.1/js/bootstrap.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- cookie js -->
    <!-- <script src="Mandor/cookie/jquery.cookie.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
    <!-- <script src="js/popper.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- swiper js -->
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <!-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->


    <!-- template custom js -->
    <script src="/js/main.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id='G-30Q4MD7E15'"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="/js/script.js"></script>


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

    <!-- page level script -->
    <!-- <script>
        $(window).on('load', function() {});
    </script> -->

    <script>
        $(document).ready(function() {
            $(".preloader").fadeOut();
        })
    </script>
    <?= $this->renderSection('script'); ?>

</body>

</html>