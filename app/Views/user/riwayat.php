<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<!-- page content here -->

<div class="container">
    <h6 class="subtitle">History Pengambilan Air <a href="/payriwayat"><br>lihat History pembayaran</a></h6>

    <div class="row">
        <div class="col-12 px-0">
            <ul class="list-group list-group-flush border-top border-bottom">
                <?php foreach ($history as $r) : ?>
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <!-- <div class="avatar avatar-50 no-shadow border-0">
                                <img src="img/user3.png" alt="">
                            </div> -->
                            </div>
                            <div class="col align-self-center pr-0">
                                <h6 class="font-weight-normal mb-1"><?= $r['status']; ?></h6>
                                <p class="text-mute small text-secondary"><?= $r['Lokasi']; ?></p>
                                <!-- <p class="text-mute small text-secondary"># <?= $r['id']; ?></p> -->
                                <p class="text-mute small text-secondary"><?= $r['created_at']; ?></p>
                            </div>
                            <div class="col-auto">
                                <h6 class="text-success"><strong><?= $r['isi']; ?> </strong> L</h6>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?= $pager->links('riwayat', 'admin_pagination') ?>
            </ul>
        </div>
    </div>
</div>
<!-- page content ends -->

<?= $this->endSection('content'); ?>