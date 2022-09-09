<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<div class="wrapper">
    <div class="container">
        <div class="flash-Error" data-flashdata="<?= session()->getFlashdata('salah'); ?>"></div>
        <form method="post" action="/user/profileupdate" enctype="multipart/form-data">

            <div class="text-center">
                <div class="form-group">
                    <div class="figure-profile shadow my-4">
                        <figure class="avatar avatar-60 border-0">
                            <?php
                            if ($akun['profil'] == "user.png") : ?>
                                <img src="/img/user/<?= $akun['profil']; ?>" alt="<?= $akun['nama_depan']; ?>">
                            <?php endif; ?>
                            <img src="<?= $akun['profil']; ?>" alt="<?= $akun['nama_depan']; ?>">
                        </figure>

                        <div class="btn btn-dark text-white floating-btn custom-file">
                            <i class="material-icons">camera_alt</i>
                            <input type="file" class="float-file  <?= ($validation->hasError('profil')) ? 'is-invalid' : ''; ?>" name="profil" id="profil" onchange="previewImg()">
                            <input type="hidden" name="profilLama" id="profilLama" value="<?= $akun['profil']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('profil'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <label class="custom-file-label" for="profil">Pilih Gambar</label>
                                <div class="invalid-feedback"><?= $validation->getError('profil'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="invalid-feedback"></div>
                </div>
            </div>


            <h6 class="subtitle">Edit Profile</h6>
            <div class="row">
                <div class="col-12 col-md-6" hidden>
                    <div class="form-group float-label active">
                        <input type="text" id="id" name="id" class="form-control" required="" value="<?= $akun['id']; ?>">
                        <label class="form-control-label">ID</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group float-label active">
                        <input type="text" id="nama_depan" name="nama_depan" class="form-control" required="" value="<?= $akun['nama_depan']; ?>">
                        <label class="form-control-label">Nama Depan</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group float-label active">
                        <input type="text" id="nama_belakang" name="nama_belakang" class="form-control" required="" value="<?= $akun['nama_belakang']; ?>">
                        <label class="form-control-label">Nama Belakang</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group float-label active mb-0">
                        <input type="text" id="telp" name="telp" class="form-control form-control-user <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="" value="<?= $akun['telp']; ?>">
                        <label class="form-control-label">Nomor Telp</label>
                        <div class="invalid-feedback"><?= $validation->getError('telp'); ?></div>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-lg btn-default text-white btn-block btn-rounded shadow"><span>Submit</span></button>
            <br>
        </form>

        <h6 class="subtitle">Ganti Email</h6>
        <form method="post" action="user/emailupdate">
            <div class="form-group float-label active">
                <input type="email" id="email1" name="email1" class="form-control form-control-lg" value="<?= $akun['email']; ?>" disabled>
                <label class="form-control-label">Email Lama</label>
            </div>
            <!-- <div class="form-group float-label">
                <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                <label class="form-control-label">Email Baru</label>
            </div> -->
            <div class="form-group float-label">
                <input type="text" class="form-control form-control-user <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="" value="">
                <label class="form-control-label">Email Baru</label>
                <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
            </div>

            <button type="submit" class="btn btn-lg btn-default btn-block btn-rounded shadow"><span>Update Email</span></button>
        </form>
    </div>
    <div class="container mt-5 ">
        <h6 class=" text-center">ID Referral saya</h6>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <p contenteditable="flase" class="text-center" id="id_referral">REFRAL ID</p>
            </div>
            <div class="col-4">
                <span onclick="copyToClipboard()" class=" material-symbols-outlined">
                    file_copy
                </span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script>
    $.ajax({
        url: "/saldo/id_referral",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#id_referral').html(data.id_referral);
            // $('#id_referral').val(data.id_referral);
        }
    });

    function copyToClipboard() {
        var Text = $("#id_referral").select()
        console.log(Text.html());
        navigator.clipboard.writeText(Text.html());

        // Alert the copied text
        Swal.fire({
            position: 'top-end',
            toast: true,
            icon: 'success',
            text: `Copy to clipboard id referral : ${Text.html()}`,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500
        })
    }
    const source = document.querySelector('div.source');

    source.addEventListener('copy', (event) => {
        const selection = document.getSelection();
        event.clipboardData.setData('text/plain', selection.toString().toUpperCase());
        event.preventDefault();
    });
</script>
<?= $this->endSection('script'); ?>