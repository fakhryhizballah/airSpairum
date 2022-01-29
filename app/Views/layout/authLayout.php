<!doctype html>
<html lang="id" class="lightblue-theme">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="stasiun pengisian air minum untuk tumbler ,Ini merupakan aplikasi spairum untuk menghubungkan anda ke stasiun air minum,.silah kan masuk Masuk ke Aplikasi Spairum">
    <meta name="google" content="notranslate" />
    <meta name="author" content="Spairum">
    <link rel="apple-touch-icon" href="/img/logo.png">
    <link rel="icon" href="favicon.ico">

    <title><?= $title; ?></title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-30Q4MD7E15"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-30Q4MD7E15');
    </script>

    <!-- Bootstrap core CSS -->
    <!-- <link href="vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link async rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Swiper CSS -->
    <!-- <link href="vendor/swiper/css/swiper.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.6/swiper-bundle.css" />

    <!-- Custom styles for this template -->
    <!-- <link href="/css/style1.css" rel="stylesheet"> -->
    <link href="/css/style1.min.css" rel="stylesheet">

    <!-- Material design icons CSS -->
    <!-- <link rel="stylesheet" href="vendor/materializeicon/material-icons.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

</head>

<body>
    <!-- Loader -->
    <div class="row no-gutters vh-100 loader-screen">
        <div class="col align-self-center text-white text-center">
            <!-- <img src="img/logo.png" alt="logo"> -->
            <h1 class="mt-3"><span class="font-weight-light ">Air </span>Spairum</h1>
            <p class="text-mute text-uppercase small">Loading</p>
            <div class="laoderhorizontal">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- Loader ends -->

    <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('gagal'); ?>"></div>
    <div class="flash-Success" data-flashdata="<?= session()->getFlashdata('Berhasil'); ?>"></div>

    <div class="wrapper ">
        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <!-- <div class="col-auto">
                    <a href="introduction.html" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                </div> -->
                <div class="col text-center"></div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <!-- header ends -->
        <?= $this->renderSection('auth'); ?>
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


    <!-- jquery, popper and bootstrap js -->
    <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- <script src="/js/popper.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.1/cjs/popper.min.js"></script> -->
    <!-- <script src="vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- cookie js -->
    <!-- <script src="vendor/cookie/jquery.cookie.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

    <!-- swiper js -->
    <!-- <script src="vendor/swiper/js/swiper.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.6/swiper-bundle.min.js"></script>

    <!-- template custom js -->
    <script async src="/js/main1.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="/js/script.js"></script>
    <!-- <script>
        $(".password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script> -->
    <!-- page level script -->
    <!-- <script>
        $(window).on('load', function() {
            var swiper = new Swiper('.introduction', {
                pagination: {
                    el: '.swiper-pagination',
                },
            });

            /* notification view and hide */
            setTimeout(function() {
                $('.notification').addClass('active');
                setTimeout(function() {
                    $('.notification').removeClass('active');
                }, 3500);
            }, 500);
            $('.closenotification').on('click', function() {
                $(this).closest('.notification').removeClass('active')
            });
        });
    </script> -->

</body>


<!-- Mirrored from maxartkiller.com/website/Fimobile/Fimobile-HTML/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2019 13:37:10 GMT -->

</html>