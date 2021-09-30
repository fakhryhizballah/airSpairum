<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>
<!-- Modal -->

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
<div class="swal" data-swal="<?= session()->getFlashdata('Pesan'); ?>"></div>
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('flash'); ?>"></div>
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
                    <p><span name="take" id="take"></span>0 mL<br><small class="text-mute">Jumlah Yang akan di ambil</small></p>
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
                                <p class="text-mute small text-secondary">Jumlah minimum yang dapat di ambil 100 mL</p>
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

<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("take");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>

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
                <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content'); ?>


<?= $this->section('script'); ?>
<script src="/scanner/vendor/instascan/instascan.min.js"></script>
<script src="/js/scane.js"></script>

<?= $this->endSection('script'); ?>