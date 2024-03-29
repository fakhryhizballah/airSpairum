<?= $this->extend('layout/user_template'); ?>
<?= $this->section('head'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.1.0/adapter.js" async></script>
<!-- <script src="/scanner/vendor/instascan/instascan.min.js" async></script> -->
<script src="/js/instascan.min.js" async></script>
<?= $this->endSection('head'); ?>

<?= $this->section('content'); ?>
<div class="swal" data-swal="<?= session()->getFlashdata('Pesan'); ?>"></div>
<div class="email" data-email=<?= session()->getFlashdata('email'); ?>></div>
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('flash'); ?>"></div>
<section>
    <div class="container">
        <div class="flash-Success" data-flashdata="<?= session()->getFlashdata('Berhasil'); ?>"></div>
        <div class="card bg-template shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60">
                            <?php
                            if ($akun['profil'] == "user.png") : ?>
                                <img src="/img/user/<?= $akun['profil']; ?>" alt="">
                            <?php endif; ?>
                            <img src="<?= $akun['profil']; ?>" alt="">
                        </figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h5 class="mb-1"><?= $akun['nama_depan']; ?>&nbsp;<?= $akun['nama_belakang']; ?></h5>
                        <p class="text-mute small">Username : <?= $akun['nama']; ?>
                            <!-- <br> ID : <?= $akun['id_user']; ?>-->
                        </p>
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
                            <span id="debit"><?= $akun['debit']; ?></span>
                            <!-- <?= $akun['debit']; ?> -->
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
<input type="hidden" id="socket" value="<?= $socket; ?>">

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
                <img src="https://cdn.spairum.my.id/img/icon/information-graphics3.png" alt="voucher redeem" class="logo-small">
                <form class="vocer" method="POST" action="saldo/voucher">
                    <div class="form-group mt-4">
                        <input required type="text" class="form-control form-control-lg text-center" id="kvoucher" name="kvoucher" placeholder="Masukan kode Voucher" aria-label="Masukan kode Voucher">
                    </div>
                    <p class="text-mute">Masukan Kode Voucher untuk menambah saldo. <br>atau hubungi:</p>
                    <a href="https://api.whatsapp.com/send?phone=6289601207398&text=Hallo%20spairum.%20Saya%20<?= $akun['nama']; ?>%2C%20mau%20top%20up%20vocher%20spairum">0896-0120-7398</a>
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
                    <video id="preview" class="kamera" playsinline></video>
                </div>
                <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="options" value="1" autocomplete="off" checked> Camera 1
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" value="2" autocomplete="off">Camera 2
                    </label>
                </div>
                <p class="text-mute">Arahkan kamera anda ke QR minuman yang anda pilih</p>
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
    // getSaldo();

    async function getSaldo() {
        let response = await fetch('/Saldo/saldoUser', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            // body: JSON.stringify(FormData),
            // dataType: "json",
        });
        let data = await response.json();
        var newDebit = parseInt(data.saldo);
        console.log(newDebit);
        saldomin(newDebit);
    }
    // console(obj);
    // saldokplus(22400);
    // saldomin(22000);

    function saldomin(id) {
        var obj = document.getElementById('debit');
        var current = parseInt(obj.innerHTML);
        var x = setInterval(function() {
            if (current <= id) {
                clearInterval(x);
            }
            obj.innerHTML = current--;
        }, 15);
        clearInterval();
    }
</script>

<script src="/js/scane.js" async></script>
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