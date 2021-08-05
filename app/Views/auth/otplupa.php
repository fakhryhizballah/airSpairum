<?= $this->extend('layout/auth_template', $title); ?>

<?= $this->section('auth'); ?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
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

            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Masukan Kode OTP dari Email anda <br> lupa password</h1>
                            <p>Masukkan kode autentikasi untuk meneganti password akun anda baru anda.</p>
                        </div>

                        <form class="user" method="POST" action="../auth/changepassword">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="otp" name="otp" placeholder="Tulis Kode dari email" value="">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Kirim
                            </button>
                        </form>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>