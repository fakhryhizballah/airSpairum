<?= $this->extend('layout/authLayout', $title); ?>

<?= $this->section('css'); ?>
<!-- Swiper CSS -->
<!-- <link href="css/swiper.min.css" rel="stylesheet"> -->

<?= $this->endSection('css'); ?>

<?= $this->section('auth'); ?>

<!-- Mirrored from maxartkiller.com/website/Fimobile/Fimobile-HTML/introduction.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Apr 2021 06:30:05 GMT -->


<!-- Swiper intro -->
<div class="swiper-container introduction pt-5">
    <div class="swiper-wrapper">
        <div class="swiper-slide overflow-hidden text-center">
            <div class="row no-gutters">
                <div class="col align-self-center px-3">
                    <img src="/img/information-graphic1.png" alt="" class="mx-100 my-5">
                    <div class="row">
                        <div class="container mb-5">
                            <h4>Amazing Finance Corner</h4>
                            <p>Lorem ipsum dolor sit amet, consect etur adipiscing elit. Sndisse conv allis.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="swiper-slide overflow-hidden text-center">
            <div class="row no-gutters">
                <div class="col align-self-center px-3">
                    <img src="/img/information-graphics2.png" alt="" class="mx-100 my-5">
                    <div class="row">
                        <div class="container mb-5">
                            <h4>Cross all over the world</h4>
                            <p>Lorem ipsum dolor sit amet, consect etur adipiscing elit. Sndisse conv allis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide overflow-hidden text-center">
            <div class="row no-gutters">
                <div class="col align-self-center px-3">
                    <img src="https://cdn.spairum.my.id/img/icon/Location%20spairum.svg" alt="Spairum refill here" class="mx-100 my-5">
                    <div class="row">
                        <div class="container mb-5">
                            <h4>Temukan lokasi spairum terdekat</h4>
                            <p>Lorem ipsum dolor sit amet, consect etur adipiscing elit. Sndisse conv allis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<!-- Swiper intro ends -->

<!-- login buttons -->
<div class="row mx-0 bottom-button-container">
    <div class="col">
        <a href="login.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Login</a>
    </div>
    <div class="col">
        <a href="signup.html" class="btn btn-white bg-white btn-lg btn-rounded shadow btn-block">Register</a>
    </div>
</div>
<!-- login buttons -->
<?= $this->endSection('auth'); ?>

<?= $this->section('script'); ?>

<!-- jquery, popper and bootstrap js -->
<!-- <script src="js/jquery-3.3.1.min.js"></script> -->
<!-- <script src="js/popper.min.js"></script> -->
<!-- <script src="vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script> -->

<!-- swiper js -->
<!-- <script src="js/swiper.min.js"></script> -->

<!-- cookie js -->
<!-- <script src="vendor/cookie/jquery.cookie.js"></script> -->

<!-- template custom js -->
<!-- <script src="js/main.js"></script> -->

<!-- page level script -->
<script>
    $(window).on('load', function() {
        var swiper = new Swiper('.introduction', {
            pagination: {
                el: '.swiper-pagination',
            },
        });

        // /* notification view and hide */
        // setTimeout(function() {
        //     $('.notification').addClass('active');
        //     setTimeout(function() {
        //         $('.notification').removeClass('active');
        //     }, 3500);
        // }, 500);
        // $('.closenotification').on('click', function() {
        //     $(this).closest('.notification').removeClass('active')
        // });
    });
</script>
<?= $this->endSection('script'); ?>

<!-- Mirrored from maxartkiller.com/website/Fimobile/Fimobile-HTML/introduction.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Apr 2021 06:30:19 GMT -->