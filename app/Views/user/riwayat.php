<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<!-- page content here -->

<div class="container">
    <div class="row shadow p-3 rounded" style="background-color:red;">
        <div class="col-12 px-0" style="margin: 7px auto 7px; width:100%">
            <span class="material-icons" style="margin: 20px auto; display:inline;">
                history
            </span>
            <h4 class="text-center" style=" display:inline;">History Pengambilan Air</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-12 px-0">
            <ul class="list-group list-group-flush border-top border-bottom">
                <?php foreach ($history as $r) : ?>
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <?php
                                $a = substr($r['status'], 0, 1);
                                if ($a == "R") : ?>
                                    <span class="material-icons">
                                        autorenew
                                    </span>
                                <?php elseif ($a == "V") : ?>
                                    <span class="material-icons">
                                        verified_user
                                    </span>
                                <?php elseif ($a == "T") : ?>
                                    <span class="material-icons">
                                        shopping_cart
                                    </span>
                                <?php else : ?>
                                    <span class="material-icons">
                                        android
                                    </span>
                                <?php endif; ?>

                            </div>
                            <div class="col align-self-center pr-0">
                                <h6 class="font-weight-normal mb-1"><?= $r['status']; ?></h6>
                                <p class="text-mute small text-secondary"><?= $r['Lokasi']; ?></p>
                                <!-- <p class="text-mute small text-secondary"># <?= $r['id']; ?></p> -->
                                <p class="text-mute small text-secondary"><?= $r['created_at']; ?></p>
                            </div>
                            <div class="col-auto">
                                <?php
                                $a = substr($r['status'], 0, 1);
                                if ($a == "R") : ?>
                                    <h6 class="text-danger"><?= $r['isi']; ?> </h6>
                                <?php else : ?>
                                    <h6 class="text-success"><?= $r['isi']; ?> </h6>
                                <?php endif; ?>
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