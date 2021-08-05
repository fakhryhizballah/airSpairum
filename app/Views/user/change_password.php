<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<div class="wrapper">
    <div class="container">
        <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('salah'); ?>"></div>

        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto text-center">
                <h4 class="mt-5"><span class="font-weight-light">Ganti </span>Password</h4>
                <form action="user/passwordupdate" method="post">
                    <div class="form-group float-label">
                        <input type="password" id="password_lama" name="password_lama" class="form-control form-control-lg" required>
                        <label class="form-control-label">Masukan Password Lama</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user <?= ($validation->hasError('password_baru')) ? 'is-invalid' : ''; ?>" id="password_baru" name="password_baru" placeholder="Password Baru">
                        <div class="invalid-feedback"><?= $validation->getError('password_baru'); ?></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user <?= ($validation->hasError('password_baru')) ? 'is-invalid' : ''; ?>" id="password_ualangi" name="password_ualangi" placeholder="Ulangi Password Baru">
                        <div class="invalid-feedback"><?= $validation->getError('password_ualangi'); ?></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-lg btn-default btn-block btn-rounded shadow"><span>Ganti Password</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>