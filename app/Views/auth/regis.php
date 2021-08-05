<?= $this->extend('layout/auth_template', $title); ?>

<?= $this->section('auth'); ?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>

                        <form class="user" method="POST" action="save">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('id_driver')) ? 'is-invalid' : ''; ?> " id="id_driver" name="id_driver" placeholder="ID account" autofocus value="<?= old('id_driver'); ?>" />
                                <div class="invalid-feedback"><?= $validation->getError('id_driver'); ?></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" placeholder="Nama" autofocus value="<?= old('nama'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('cv')) ? 'is-invalid' : ''; ?>" id="cv" name="cv" placeholder="Nama Cv Supalayer" autofocus value="<?= old('cv'); ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email Address" value="<?= old('email'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="No Telp" autofocus value="<?= old('telp'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('telp'); ?></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
                                    <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user <?= ($validation->hasError('password2')) ? 'is-invalid' : ''; ?>" id="password2" name="password2" placeholder="Repeat Password">
                                    <div class="invalid-feedback"><?= $validation->getError('password2'); ?></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr />
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="/">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>