<?= $this->extend('layout/templateBack'); ?>
<?= $this->section('MainBack'); ?>
.
<div class="row">
    <div class="col-lg">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4"> Ganti No telp</h1>
        </div>
        <form class="user" method="POST" action="up_telp/<?= $akun['id']; ?>">
            <?= csrf_field(); ?>
            <div class="form-group">
                <input type="text" class="form-control form-control-user  <?= ($validation->hasError('telp')) ? 'is-invalid' : ''; ?>" id="telp" name="telp" placeholder="No Telp" autofocus value="<?= old('telp'); ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('telp'); ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Edit
            </button>
        </form>
        <hr>

        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Ganti foto</h1>
        </div>
        <form class="user" method="POST" action="up_profil/<?= $akun['id']; ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <img src="/img/driver/<?= $akun['profil']; ?>" class="img-thumbnail img-preview mx-auto d-block">
                    </div>
                    <div class="col-md-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('profil')) ? 'is-invalid' : ''; ?>" id="profil" name="profil" onchange="previewImg()">
                            <label class="custom-file-label" for="profil">Pilih Gambar</label>
                            <div class="invalid-feedback"><?= $validation->getError('profil'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="invalid-feedback"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Edit
            </button>
        </form>


    </div>
    <?= $this->endSection('MainBack'); ?>