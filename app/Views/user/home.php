<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<div class="swal" data-swal="<?= session()->getFlashdata('Pesan'); ?>"></div>
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('flash'); ?>"></div>
<section>
    <div class="container">
        <div class="flash-Success" data-flashdata="<?= session()->getFlashdata('Berhasil'); ?>"></div>
        <div class="card bg-template shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60"><img src="/img/user/<?= $akun['profil']; ?>" alt=""></figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h5 class="mb-1"><?= $akun['nama_depan']; ?>&nbsp;<?= $akun['nama_belakang']; ?></h5>
                        <p class="text-mute small">Username : <?= $akun['nama']; ?>
                            <!-- <br> ID : <?= $akun['id_user']; ?></p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-0 font-weight-normal">
                            <span class="material-icons">
                                account_balance_wallet
                            </span>
                            <?= $akun['debit']; ?>
                        </h3>
                        <p class="text-mute">Saldo Air</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-default btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"><i class="material-icons">add</i></button>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-none">
                <div class="row">
                    <!-- <div class="col">
                    <p><?= $akun['kredit']; ?> mL<i class="material-icons text-danger vm small"></i><br><small class="text-mute">Telah di ambil</small></p>
                </div> -->
                    <!-- <div class="col text-center">
                    <p>2.24 L<i class="material-icons text-success vm small">arrow_upward</i><br><small class="text-mute">today</small></p>
                </div> -->
                    <div class="col text-center">
                        <p><span name="take" id="take"></span>0 mL<br><small class="text-mute">Jumlah Yang akan di
                                ambil</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-template shadow mt-4 h-190">
            <div class="col">
                <h6 class="subtitle">Sesuaikan kebutuhan untuk pengambilan air</h6>
            </div>
            <div class="card shadow border-0 mb-2">
                <form action="/Ajax/index" class="user" method="POST" id="take">
                    <?= csrf_field(); ?>
                    <div class="card-body mb-2">
                        <div class="form-group user-form">
                            <div class="row">
                                <div class="col">
                                    <div class="slidecontainer">
                                        <input type="range" min="10" max="120" value="22" class="slider" id="myRange" name="take">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p class="text-mute small text-secondary">Jumlah minimum yang dapat di ambil 100 mL
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <input type="hidden" class="form-control form-control-lg text-center" id="code">
                        </div>
                        <!-- <button type="submit" class="btn btn-user btn-block btn-outline-template btn-rounded bg-template">
                        SCAN QR CODE
                    </button> -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-user btn-block btn-outline-template btn-rounded bg-template" onclick="scane()">
                            SCAN QR CODE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- <div class="wrapper"> -->
<div class="container botol">
    <!-- page content here -->
    <!-- <div data-pagination='{"el": ".swiper-pagination"}'  data-space-between="50" data-loop="true" class="swiper-container swiper-init demo-swiper"> -->
    <div data-pagination='{"el": ".swiper-pagination"}' " class=" swiper-container ">
    <!-- <div class=" swiper-pagination"></div> -->
    <div class="swiper-wrapper">
        <?php foreach ($botol as $r) : ?>
            <div class="swiper-slide swiper-slide card shadow  text-white" id="mybotol">
                <div class="card-header bg-template">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title text-center text-white">Botol Saya</h5>
                        </div>
                        <div class="col-2">
                            <div onclick="hapusbtol('<?= $r['id_botol']; ?>')">
                                <span class="material-icons">
                                    delete
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card shadow border-0 mb-2"> -->
                <div class="card shadow">
                    <div class="card-body border-bottom mb-2 text-secondary">
                        <div class="row">
                            <div class="col-4">
                                <img src="/img/botol/botol.jpg" alt="">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <h5 class="f-light text-left text-template"><?= $r['nama_botol']; ?></h5>
                                </div>
                                <div class="row">
                                    <p class="mb-0 text-secondary f-sm text-black">
                                        jenis Botol : <?= $r['jenis_botol']; ?>
                                        <br>Ukuran Botol : <?= $r['ukuran_botol']; ?> mL
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <!-- <button class="btn btn-info btn-block btn-outline-template btn-rounded bg-template"></button> -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="swiper-slide swiper-slide card shadow text-white">
            <!-- <div class="card shadow-sm border-0 mb-3 bg-warning text-white"> -->
            <div class="card-header bg-template">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-white text-center">Tambahkan Botol</h5>
                        <div id="qr-reader-results"></div>
                    </div>
                </div>
            </div>
            <div class="card shadow border-0 mb-2">
                <div class="card-body mb-2 text-secondary">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img class="text-center" src="/img/botol/botol.jpg" alt="Botol Spairum">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-none">
                    <button class="btn btn-info btn-block btn-outline-template btn-rounded bg-template" onclick="addBotol()">Tambah Botol</button>
                </div>
            </div>
            <!-- </div> -->
        </div>
        <!-- <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">Slide 5</div>
                <div class="swiper-slide">Slide 6</div>
                <div class="swiper-slide">Slide 7</div>
                <div class="swiper-slide">Slide 8</div>
                <div class="swiper-slide">Slide 9</div>
                <div class="swiper-slide">Slide 10</div> -->
    </div>
</div>
<!-- page content ends -->
</div>
<!-- </div> -->



<?= $this->endSection('content'); ?>

<?= $this->section('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="addmoney" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <img src="img/infomarmation-graphics2.png" alt="logo" class="logo-small">
                <form class="vocer" method="POST" action="user/voucher">
                    <div class="form-group mt-4">
                        <input required type="text" class="form-control form-control-lg text-center" id="kvoucher" name="kvoucher" placeholder="Masukan kode Voucher" aria-label="Masukan kode Voucher">
                    </div>
                    <p class="text-mute">Masukan Kode Voucher untuk menambah saldo.</p>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block" type="button">proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-pindai" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="camera">
                    <video id="preview" class="kamera"></video>
                </div>
                <p class="text-mute">Arahkan kamera anda ke QR minuman yang anda pilih</p>
            </div>
            <div class="modal-body text-center pt-0">
                <!-- <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                    </label>
                </div> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-addBotol" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <div class="camera">
                    <div id="app">
                        <p class="error">{{ error }}</p>
                        <p class="error" v-if="noFrontCamera">
                            You don't seem to have a front camera on your device
                        </p>

                        <p class="error" v-if="noRearCamera">
                            You don't seem to have a rear camera on your device
                        </p>
                        <!-- <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream> -->
                        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">

                        </qrcode-stream>
                        <!-- <button class="btn btn-rounded bg-template" @click="switchCamera">
                            <span class="material-icons">
                                flip_camera_ios
                            </span>
                        </button> -->
                        <button @click="switchCamera">
                            <img alt="switch camera">
                        </button>
                    </div>
                </div>
                <p class="text-mute">Arahkan kamera anda ke QR Botol</p>
            </div>
            <div class="modal-body text-center pt-0">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('modal'); ?>




<?= $this->section('script'); ?>

<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("take");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>

<script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js" async></script>
<script src="/scanner/vendor/instascan/instascan.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://unpkg.com/vue-qrcode-reader/dist/VueQrcodeReader.umd.min.js"></script>
<script src="/js/scane.js" async></script>
<script src="/js/botol.js" async></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        // keyboard: {
        //     enabled: true,
        // },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>


<?= $this->endSection('script'); ?>