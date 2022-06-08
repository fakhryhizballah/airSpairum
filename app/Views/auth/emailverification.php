<!-- <?= $this->extend('/layout/auth_template', $title); ?> -->
<?= $this->extend('layout/authLayout', $title); ?>
<?= $this->section('auth'); ?>
<div class="wrapper">
    <div class="container">
        <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('salah'); ?>"></div>
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto text-center">
                <h4 class="mt-5"><span class="font-weight-light">Verifikasi </span>Email anda</h4>
                <br>
                <img src="https://cdn.spairum.my.id/img/Sent-Message.svg" alt="Ganti password" class="logo-small">
                <br>
                <div class="text-center">
                    <p class="text-secondary mt-4 d-block">Pastikan kami akan mengirimi kode autentikasi untuk Reset Password anda.</p>
                </div>
                <form class="form-signin mt-3" action="../auth/passwordupdate" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg text-center <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" value="<?= $akun['email']; ?>" id="email" name="email" placeholder="Masukan Email anda">
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <button id="myBtn" onclick="kirimOTP()" class="btn btn-default btn-lg btn-rounded shadow btn-block"><span>Kirim kode OTP</span></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center <?= ($validation->hasError('password2')) ? 'is-invalid' : ''; ?>" id="password2" name="password2" placeholder="Masukan Kode">
                        <div class="invalid-feedback"><?= $validation->getError('password2'); ?></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg text-center" id="id_user" name="id_user" value="<?= $akun['id_user']; ?>">
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block"><span>Verified</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const btn = document.getElementById("myBtn")

    function kirimOTP() {
        btn.disabled = true;

        // Update the count down every 1 second
        let response = await fetch('/Saldo/cekUser', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(FormData),
            dataType: "json",
        });
        var seconds = 10;
        var x = setInterval(function() {

            // Get today's date and time

            console.log(seconds);
            // Display the result in the element with id="demo"
            document.getElementById("myBtn").innerHTML = "jika anda tidak mendapatakn otp lagi setelah " + seconds + " s ";
            seconds -= 1;


            // If the count down is finished, write some text
            if (seconds < 0) {
                clearInterval(x);
                document.getElementById("myBtn").innerHTML = "Kirim OTP Lagi";
                btn.disabled = false;
            }
        }, 1000);
        console.log('Button Activated')
    }
</script>

<?= $this->endSection('auth'); ?>