<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

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
                    <h3 class="mb-0 font-weight-normal"><?= $akun['debit']; ?> mL</h3>
                    <p class="text-mute">Saldo Air</p>
                </div>
                <div class="col-auto">
                    <!-- <button class="btn btn-default btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"><i class="material-icons">add</i></button> -->
                </div>
            </div>
        </div>
        <div class="card-footer bg-none">
            <div class="row">
                <div class="col">
                    <p><?= $akun['kredit']; ?> mL<i class="material-icons text-danger vm small"></i><br><small class="text-mute">Telah di ambil</small></p>
                </div>
                <!-- <div class="col text-center">
                    <p>2.24 L<i class="material-icons text-success vm small">arrow_upward</i><br><small class="text-mute">today</small></p>
                </div> -->
                <div class="col text-right">
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
            <form class="user" method="POST" action="/user/take">
                <div class="card-body mb-2">
                    <div class="form-group user-form">
                        <div class="row">
                            <div class="col">
                                <div class="slidecontainer">
                                    <input type="range" min="10" max="120" value="22" class="slider" id="myRange" name="take">\
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-mute small text-secondary">Jumlah minimum yang dapat di ambil 100 mL</p>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-user btn-block btn-outline-primary btn-rounded bg-template">
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