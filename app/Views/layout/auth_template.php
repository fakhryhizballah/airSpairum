<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Login,Air,spairum,Air spairum,masuk,Air,spairum,stasiun pengisian air minum untuk tumbler">
    <meta name="description" content="stasiun pengisian air minum untuk tumbler ,Ini merupakan aplikasi spairum untuk menghubungkan anda ke stasiun air minum,
    .silah kan masuk Masuk ke Aplikasi Spairum">
    <meta name="google" content="notranslate" />
    <meta name="author" content="Spairum">
    <link rel="apple-touch-icon" href="/img/logo.png">
    <link rel="icon" href="favicon.ico">
    <!-- Google Tag Manager -->
    <!-- End Google Tag Manager -->

    <title><?= $title; ?></title>


    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- my auth.css -->
    <link rel="stylesheet" href="/css/auth.css" disabled>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" disabled>
    <!-- My font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" disabled>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" disabled>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" disabled>


    <link rel="manifest" href="/Manifes/manifes.json">
    <meta name="theme-color" content="#2196f3">
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

<body class="">

    <?= $this->renderSection('auth'); ?>


    <!-- Bootstrap core JavaScript-->
    <script defer src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Core plugin JavaScript-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- Custom scripts for all pages-->
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>
    <!-- sweet alert -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script async src="/js/script.js"></script>
    <script defer>
        $(".password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>

</body>

</html>