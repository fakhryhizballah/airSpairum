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
                <img src="https://cdn.spairum.my.id/image/1655404910809-Workchat-bro.svg" alt="whatsapp valid?" class="logo-small">
                <br>
                <div class="text-center">
                    <p class="text-secondary mt-4 d-block">Silahkan cek whatsapp anda, Kami mengirimi kode autentikasi untuk verifikasi whatsapp.</p>
                </div>
                <form class="form-signin mt-3" action="../auth/watoken" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-lg text-center <?= ($validation->hasError('whatsapp')) ? 'is-invalid' : ''; ?>" value="<?= $akun['telp']; ?>" id="whatsapp" name="whatsapp" placeholder="Masukan nomor whatsapp anda">
                        <div class="invalid-feedback"><?= $validation->getError('whatsapp'); ?></div>
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control form-control-lg text-center <?= ($validation->hasError('token')) ? 'is-invalid' : ''; ?>" id="token" name="token" placeholder="Masukan Kode">
                        <div class="invalid-feedback"><?= $validation->getError('token'); ?></div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col">
                            <p id="resend" class="text-secondary mt-4 d-block">Jika tidak menerima whatsapp,<br>klik <a onclick="kirimOTP()" class=""> kirim ulang</a></p>
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
                    </div>
                </form>
            </div>
        </div>
        <a href="../auth/waSkip" class="mt-4 d-block text-right">skip</a>
    </div>
</div>

<script>
    async function kirimOTP() {
        const whatsapp = document.getElementById("whatsapp").value
        let FormData = {
            whatsapp
        };
        // console.log(FormData);
        let response = await fetch('/auth/resewa', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(FormData),
            // body: email,
            dataType: "json",
        });

        console.log(response);
        // Update the count down every 1 second
        var seconds = 180;
        var x = setInterval(function() {
            // Get today's date and time
            console.log(seconds);
            // Display the result in the element with id="demo"
            document.getElementById("resend").innerHTML = "silahkan cek whatsapp otp. anda baru bisa mengirim otp lagi setelah " + seconds + " s ";
            seconds -= 1;
            // If the count down is finished, write some text
            if (seconds < 0) {
                clearInterval(x);
                document.getElementById("resend").innerHTML = "Jika tidak menerima whatsapps,<br>klik <a onclick=kirimOTP() >" + "kirim ulang</a>";
                // btn.disabled = false;
            }
        }, 1000);
        console.log('Button Activated')
        clearInterval();
    }
</script>

<?= $this->endSection('auth'); ?>