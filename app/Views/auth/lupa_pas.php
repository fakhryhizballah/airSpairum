<?= $this->extend('layout/authLayout', $title); ?>

<?= $this->section('auth'); ?>

<div class="row no-gutters login-row">
    <div class="col align-self-center px-3 text-center">
        <br>
        <img src="https://cdn.spairum.my.id/img/Forgot%20password.svg" alt="Lupa Password" class="logo-small">
        <br>
        <div class="text-center">
            <p class="text-secondary mt-4 d-block">Masukkan email atau username untuk kami akan mengirimi kode autentikasi untuk Reset Password anda.</p>
        </div>
        <form class="form-signin mt-3" method="POST" action="/sendemail">
            <?= csrf_field(); ?>
            <div class="form-group">
                <input type="text" class="form-control form-control-lg text-center <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Tulis alamat Email akun anda" value="<?= old('email'); ?>">
                <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
            </div>
            <p class="text-secondary mt-4 d-block">Jika Anda sudah memiliki kata sandi,<br> <a href="/" class="">Login</a> di sini</p>
            <hr>
            <!-- login buttons -->
            <div class="row mx-0 ">
                <div class="col">
                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Reset Password</button>
                </div>
            </div>
            <!-- login buttons -->
        </form>
    </div>
</div>


<?= $this->endSection(); ?>