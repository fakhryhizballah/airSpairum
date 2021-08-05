<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <img src="/img/driver/<?= $akun['profil']; ?>" class="profil" alt="">
        <h1 class="name "><?= $akun['nama']; ?></h1>
        <p class="name-crop"><?= $akun['cv']; ?></p>
    </div>
</div>
<div class="view-back">
    <div class="card card-dasbord shadow">
        <div class="row no-gutters justify-content-center">
            <div class="col-xs card-block">
                <div class="card-item ">
                    <h5 class="card-item-title"><?= $akun['Trip']; ?></h5>
                </div>
                <p class="text-center" style="padding-top: 10px;">Trip</p>
            </div>
            <div class="col-xs card-block">
                <div class="card-item">
                    <h5 class="card-item-title"><?= $akun['liter']; ?></h5>
                </div>
                <p class="text-center" style="padding-top: 10px;">Liter</p>
            </div>
            <div class="col-xs card-block">
                <div class="card-item">
                    <h5 class="card-item-title"><?= $akun['poin']; ?></h5>
                </div>
                <p class="text-center" style="padding-top: 10px;">Point</p>
            </div>
        </div>
    </div>
    <div class="card card-iden shadow">
        <h5 class="card-iden-h5">Identitas Akun</h5>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Nama</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $akun['nama']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">ID Akun</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $akun['id_driver']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Nomor Telpon</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $akun['telp']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Setting</p>
            </div>
            <div class="col">
                <a href="/driver/edit" class="card-iden-p2 text-muted"><u>Edit Profile</u></a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1"></p>
            </div>
            <div class="col">
                <a href="/Auth/logout" class=" card-iden-p2 "><u>Logout</u></a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>