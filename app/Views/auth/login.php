<?= $this->extend('layout/auth_template'); ?>

<?= $this->section('auth'); ?>


<!-- Outer Row -->
<div class="row justify-content-center">

    <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
    <div class="col-lg-7">

        <!-- Nested Row within Card Body -->
        <div class="row">
            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
            <div class="col-lg">
                <img src="/img/ig_gS2_icon.ico" class="logo" alt="logo spairum">
                <div class="from-auth user">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                    </div>

                    <?php if (session()->getFlashdata('flash')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong><?= session()->getFlashdata('flash');  ?></strong>
                        </div>

                        <script>
                            $(".alert").alert();
                        </script>
                    <?php endif; ?>
                    <div class="swal" data-swal="<?= session()->getFlashdata('gagal'); ?>"></div>
                    <div class="flash-Success" data-flashdata="<?= session()->getFlashdata('Berhasil'); ?>"></div>



                    <form class="user" method="POST" action="Auth/login">
                        <div class=" form-group user-form">
                            <img class="icon" src="/img/Vector.png" alt="">
                            <input type="text" class="form-control form-control-user <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" style="padding-left: 50px;" id="username" name="nama" placeholder="Username atau Email atau Nomor Telepon" autofocus value="<?= old('nama'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>

                            <div class="form-group user-form">
                                <img class="icon" src="/img/Group 13.png" alt="">
                                <input type="password" class="form-control form-control-user" style="padding-left: 50px;" id="password" name="password" placeholder="Password" required>
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon password"></span>
                            </div>

                            <!-- <div class="form-group user-form">
                                <select class="form-control level  <?= ($validation->hasError('level')) ? 'is-invalid' : ''; ?>" id="level" name="level">
                                    <option selected>Pilih login sebagai</option>
                                    <option value="1">User</option>
                                    <option value="2">Driver</option>
                                    <option value="3">Admin</option>
                                </select>
                                <div class="invalid-feedback"><?= $validation->getError('level'); ?></div>
                            </div> -->
                            <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div> -->
                            <button type="submit" class="btn btn-user btn-block">
                                Login
                            </button>
                            <!-- <p class="font-weight-normal text-right" style="margin-top: 16px;">Forget <strong class="text-primary">Password<strong></p> -->

                            <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                            <!-- </form> -->
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/daftar">Create an Account!</a>
                            </div>
                            <hr>
                            <div class="text-right">
                                <a class="small" href="/lupa">lupa<strong class="text-primary">Password<strong></a>
                            </div>
                        </div>
                </div>
            </div>


        </div>

    </div>



    <?= $this->endSection('auth'); ?>