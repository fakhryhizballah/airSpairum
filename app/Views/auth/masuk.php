<?= $this->extend('layout/authLayout', $title); ?>

<?= $this->section('auth'); ?>



<div class="row no-gutters login-row">
    <div class="col align-self-center px-3 text-center">
        <br>
        <!-- <img src="/img/spairum logo.png" alt="logo" class="logo-small"> -->
        <img src="/img/spairum logo.png" alt="Logo Spairum" class="logo-small">
        <br>
        <p class="text-mute text-uppercase ">Login Spairum</p>
        <form class="form-signin mt-3" method="POST" action="Auth/login">
            <?= csrf_field(); ?>
            <div class="form-group">
                <input type="text" class="form-control form-control-lg text-center<?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="username" name="nama" required placeholder="Masukan Username/Email/No.Tel" autofocus value="<?= old('nama'); ?>">
                <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
            </div>
            <!-- <div class="form-group ">
                <input type="text" class="form-control form-control-lg  text-center<?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="username" name="nama" required placeholder="Masukan Username/Email/No.Tel" autofocus value="<?= old('nama'); ?>"" required="">
            </div> -->

            <div class=" form-group">
                <input type="password" class="form-control form-control-lg text-center" id="password" name="password" placeholder="Password" required>
            </div>

            <!-- <span toggle="#password" class="mt-4 text-primary fa fa-fw fa-eye field-icon password "></span> -->
            <div class="text-right">
                <a class="small" href="/lupa">lupa<strong class=" text-primary"> Password<strong></a>
            </div>
        </form>
        <hr>
        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">
            Masuk
        </button>
        <hr>
        <a href="<?= $urlOauth; ?>" class="btn btn-default btn-lg btn-rounded shadow btn-block">
            <i class="fab fa-google-plus-g"></i> Masuk dengan Google
        </a>
        <hr>
    </div>
    <div class="row mx-0 bottom-button-container">
        <div class="col">
            <a href="/lupa" class="btn btn-default btn-lg btn-rounded shadow btn-block">Lupa Password</a>
        </div>
        <div class="col">
            <a href="/daftar" class="btn btn-white bg-white btn-lg btn-rounded shadow btn-block">Create an Account!</a>
        </div>
    </div>
</div>



<?= $this->endSection('auth'); ?>