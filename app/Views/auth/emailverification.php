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
                            <p id="resend" class="text-secondary mt-4 d-block">Jika tidak menerima email,<br>klik <a onclick="kirimOTP()" class=""> kirim ulang</a></p>
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
        // let data = await response.json();
        // if (data.status == 'error') {
        //     Swal.fire('Oops', data.message, 'error');
        //     return;
        // }
        console.log(response);
        // Update the count down every 1 second
        var seconds = 180;
        var x = setInterval(function() {
            // Get today's date and time
            console.log(seconds);
            // Display the result in the element with id="demo"
            document.getElementById("resend").innerHTML = "silahkan cek emalil otp. anda baru bisa mengirim otp lagi setelah " + seconds + " s ";
            seconds -= 1;
            // If the count down is finished, write some text
            if (seconds < 0) {
                clearInterval(x);
                document.getElementById("resend").innerHTML = "Jika tidak menerima email,<br>klik <a onclick=kirimOTP() >" + "kirim ulang</a>";
                // btn.disabled = false;
            }
        }, 1000);
        console.log('Button Activated')
        clearInterval();
    }
</script>

<?= $this->endSection('auth'); ?>