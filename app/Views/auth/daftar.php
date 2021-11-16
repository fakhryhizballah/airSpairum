<?= $this->extend('layout/auth_template', $title); ?>

<?= $this->section('auth'); ?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <?php if (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><?= session()->getFlashdata('gagal');  ?></strong>
                </div>

                <script>
                    $(".alert").alert();
                </script>
            <?php endif; ?>
            <div class="swal" data-swal="<?= session()->getFlashdata('Pesan'); ?>"></div>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>

                        <form class="user" method="POST" action="auth/userSave" autocomplete="on">
                            <?= csrf_field(); ?>
                            <!-- <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('id_user')) ? 'is-invalid' : ''; ?> " id="id_user" name="id_user" placeholder="ID account" autofocus value="<?= old('id_user'); ?>" />
                                <div class="invalid-feedback"><?= $validation->getError('id_user'); ?></div>

                            </div> -->
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" placeholder="Username" autofocus value="<?= old('nama'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama_depan')) ? 'is-invalid' : ''; ?>" id="nama_depan" name="nama_depan" placeholder="Nama Depan" autofocus value="<?= old('nama_depan'); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('nama_depan'); ?></div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama_belakang')) ? 'is-invalid' : ''; ?>" id="nama_belakang" name="nama_belakang" placeholder="Nama Belakang" autofocus value="<?= old('nama_belakang'); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('nama_belakang'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email Address" value="<?= old('email'); ?>">
                                <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="Nomor Telepon" autofocus value="<?= old('telp'); ?>">
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
                        <!-- <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div> -->
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