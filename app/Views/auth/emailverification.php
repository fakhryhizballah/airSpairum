<!-- <?= $this->extend('/layout/auth_template', $title); ?> -->
<?= $this->extend('layout/authLayout', $title); ?>
<?= $this->section('auth'); ?>
<div class="wrapper">
    <div class="container">
        <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('salah'); ?>"></div>
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto text-center">
                <h4 class="mt-5"><span class="font-weight-light">Verifikasi </span>Email</h4>
                <br>
                <img src="https://cdn.spairum.my.id/img/Sent-Message.svg" alt="Email valid" class="logo-small">
                <br>
                <div class="text-center">
                    <p class="text-secondary mt-4 d-block">Silahkan cek Kontak Email anda, Kami mengirimi kode autentikasi untuk verifikasi email.</p>
                </div>
                <form class="form-signin mt-3" action="../auth/emailtoken" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg text-center <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" value="<?= $akun['email']; ?>" id="email" name="email" placeholder="Masukan Email anda">
                        <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control form-control-lg text-center <?= ($validation->hasError('token')) ? 'is-invalid' : ''; ?>" id="token" name="token" placeholder="Masukan Kode">
                        <div class="invalid-feedback"><?= $validation->getError('token'); ?></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <p id="resend" class="text-secondary mt-4 d-block">jika belum menerima email silahkan <br>klik <a onclick="kirimOTP()" class=""> kirim OTP Email</a></p>
                            <!-- <button id="myBtn" onclick="kirimOTP()" class="btn btn-default btn-lg btn-rounded shadow btn-block"><span>Kirim kode OTP</span></button> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-lg text-center" id="id_user" name="id_user" value="<?= $akun['id_user']; ?>">
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block"><span>Verified</span></button>
                        </div>
                </form>
            </div>
            <a href="/auth/logout" class="mt-4 d-block text-right">Keluar</a>
        </div>
    </div>
</div>

<script>
    async function kirimOTP() {
        const email = document.getElementById("email").value
        let FormData = {
            email
        };
        // console.log(FormData);
        let response = await fetch('/auth/resedemail', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(FormData),
            // body: email,
            dataType: "json",
        });
        let data = await response.json();
        console.log(data);
        if (data.status == 200) {
            // Update the count down every 1 second
            var seconds = 180;
            var x = setInterval(function() {
                // Get today's date and time
                // console.log(seconds);
                // Display the result in the element with id="resend"
                document.getElementById("resend").innerHTML = "silahkan cek kontak email anda. anda baru bisa mengirim otp lagi setelah " + seconds + " s ";
                seconds -= 1;
                // If the count down is finished, write some text
                if (seconds < 0) {
                    clearInterval(x);
                    document.getElementById("resend").innerHTML = "Jika tidak menerima emali,<br>klik <a onclick=kirimOTP() >" + "kirim ulang</a> atau hubungi <br> <a href='https://wa.me/+6289601207398'>Admin spairum</a></a>";
                    // btn.disabled = false;
                }
            }, 1000);
            console.log('Button Activated')
            clearInterval();
        } else {
            console.log(data.msg)
            document.getElementById("pesan").innerHTML = data.msg;
            $('#warning').modal('show');
            // alert(data.message);
        }
    }
</script>

<?= $this->endSection('auth'); ?>

<?= $this->section('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="warning" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <img id="img" src="https://cdn.spairum.my.id/image/1655733077378-Businessinequality-pana.svg" alt="waring" class="logo-small">
                <p class="text-mute" id="pesan"></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('modal'); ?>