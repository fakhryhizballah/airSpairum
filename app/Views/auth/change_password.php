<!-- <?= $this->extend('/layout/auth_template', $title); ?> -->
<?= $this->extend('layout/authLayout', $title); ?>
<?= $this->section('auth'); ?>
<div class="wrapper">
    <div class="container">
        <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('salah'); ?>"></div>
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto text-center">
                <h4 class="mt-5"><span class="font-weight-light">Ganti </span>Password</h4>
                <br>
                <img src="https://cdn.spairum.my.id/img/Reset%20password-pana.svg" alt="Ganti password" class="logo-small">
                <br>
                <form class="form-signin mt-3" action="../auth/passwordupdate" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password Baru">
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center <?= ($validation->hasError('password2')) ? 'is-invalid' : ''; ?>" id="password2" name="password2" placeholder="Ulangi Password Baru">
                        <div class="invalid-feedback"><?= $validation->getError('password2'); ?></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg text-center" id="id_user" name="id_user" value="<?= $akun['id_user']; ?>">
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block"><span>Ganti Password</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('auth'); ?>