<?= $this->extend('layout/templateBack'); ?>
<?= $this->section('MainBack'); ?>

<!-- 
<nav class="nav nav-pills nav-fill justify-content-center">
    <div class="row no-gutters justify-content-center ">

        <li class="nav-item col-xs text-center nav-margin">
            <img class="status buttonNav" src="/img/Group 14.png" alt="">
            <a class="nav-link fontNav" href="#">Selesai</a>

        </li>
        <li class="nav-item col-xs text-center nav-margin">
            <img class="status buttonNav" src="/img/Group 8.png" alt="">
            <a class="nav-link fontNav" href="#">Batal</a>
        </li>
        <li class="nav-item col-xs text-center nav-margin">
            <img class="status buttonNav" src="/img/Group 10.png" alt="" href="page/Histori">
            <a class="nav-link fontNav" href="page/Histori">Proses</a>
        </li>
    </div>
</nav> -->

<?php foreach ($history as $s) : ?>
    <div class="card card-iden shadow">
        <h5 class="card-iden-h5"><?= $s['status']; ?></h5>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">lokasi</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['Lokasi']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">ID Stasiun</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['Id_slave']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Jumlah Air</p>
            </div>
            <div class="col">
                <p class="card-iden-p2 "><strong><?= $s['isi']; ?> </strong> L</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Tanggal</p>
            </div>
            <div class="col">
                <p class="card-iden-p2 text-muted"><?= $s['created_at']; ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- Looping -->
<!-- 
<div class="card card-iden shadow">
    <h5 class="card-iden-h5">Selesai</h5>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">ID Transaksi</p>
        </div>
        <div class="col">
            <p class="card-iden-p2">002019233</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">ID Stasiun</p>
        </div>
        <div class="col">
            <p class="card-iden-p2">00012287</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">Lokasi</p>
        </div>
        <div class="col">
            <p class="card-iden-p2">Water Front Barito</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">Jumlah Air</p>
        </div>
        <div class="col">
            <p class="card-iden-p2 "><strong>20 </strong> L</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">Tanggal</p>
        </div>
        <div class="col">
            <p class="card-iden-p2 text-muted">02/7/2020</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="card-iden-p1">Waktu</p>
        </div>
        <div class="col">
            <p class="card-iden-p2 text-muted">09.15</p>
        </div>
    </div>
</div>
 -->
<?= $this->endSection('MainBack'); ?>