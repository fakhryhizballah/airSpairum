<?= $this->extend('layout/authLayout', $title); ?>

<?= $this->section('auth'); ?>

<div class="row no-gutters login-row">
    <div class="col align-self-center px-3 text-center">
        <br>
        <img src="https://cdn.spairum.my.id/img/Enter%20OTP-cuate.svg" alt="OTP Lupa Password" class="logo-small">
        <br>
        <form class="form-signin mt-3" method="POST" action="../auth/changepassword">
            <?= csrf_field(); ?>
            <div class="form-group">
                <input type="number" class="form-control form-control-lg text-center" id="otp" name="otp" placeholder="Tulis Kode dari email" value="">
            </div>
            <p class="text-secondary mt-4 d-block">Cek Email dan Masukkan kode autentikasi untuk meneganti password akun anda baru anda.</p>
            <hr>
            <div class="row mx-0 ">
                <div class="col">
                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Kirim</button>
                </div>
            </div>
        </form>
        <!-- login buttons -->
        <!-- login buttons -->
    </div>
</div>

<!-- login buttons -->
<!-- <div class="row mx-0 bottom-button-container">
    <div class="col">
        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Kirim</button>
    </div>
</div> -->
<!-- login buttons -->

<?= $this->endSection(); ?>