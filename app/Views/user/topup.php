<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="swal" data-swal="<?= session()->getFlashdata('Pesan'); ?>"></div>
    <!-- page content here -->
    <h3 class="font-weight-light text-center mt-4">Isi Ulang Saldo Air<br><span class="text-template">Voucher</span> atau
        <span class="text-template">TopUp</span>
    </h3>
    <p class="text-secondary text-mute text-center mb-4">Isi ulang saldo air bisa dengan vocer isi ulang atau menggunakan Qris/Gopay</p>


    <div class="card shadow border-0 mb-3">
        <div class="card-body">
            <div class="row h-100">
                <div class="col-auto pr-0 align-middle">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-info"></div>
                        <i class="material-icons text-success md-36">redeem</i>
                    </div>
                </div>
                <div class="col">
                    <h3><span class="text-mute text-secondary">Isi ulang saldo air </span><small class=" text-template ">Kode Voucher</small></h3>
                </div>
            </div>
            <div class="row">
                <div class="ml-4 mt-3">
                    <form class="vocer" method="POST" action="saldo/voucher">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="kvoucher" name="kvoucher" placeholder="Masukan kode Voucher" aria-label="Masukan kode Voucher" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn bg-template" type="button">proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 mb-3">
        <div class="card-body">
            <div class="row h-100">
                <div class="col-auto pr-0">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-primary"></div>
                        <i class="material-icons text-primary md-36">local_drink</i>
                    </div>
                </div>
                <div class="col">
                    <h3><span class="text-mute text-secondary">Isi ulang saldo air </span><small class=" text-template ">Go-pay</small></h3>
                    <form class="vocer" method="POST" action="/snap">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="harga" name="harga" value="10000">
                            <div class="input-group-append">
                                <button type="submit" class="mb-2 btn btn-rounded bg-template">Beli</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="id" name="id" value="5.000mL">
                        <input type="hidden" class="form-control" id="paket" name="paket" value="Paket Hemat">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 mb-3">
        <div class="card-body">
            <div class="row h-100">
                <div class="col-auto pr-0 align-middle">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-primary"></div>
                        <i class="material-icons text-primary md-36">water_drop</i>
                    </div>
                </div>
                <div class="col">
                    <h3><span class="text-mute text-secondary">Bebagi Air ke </span><small class=" text-template ">Sobat spairum</small></h3>
                </div>
            </div>
            <div class="row">
                <div class="ml-4 mt-3">
                    <!-- <form class="vocer" method="POST" onsubmit="return validateForm()"> -->
                    <div class="input-group input-group-sm w-100">
                        <div class="input-group-prepend">
                            <input type="number" class="input-group-text " id="nominal" name="nominal" style="width:75px;" placeholder=" nominal">
                        </div>
                        <input type="number" class="form-control" id="nomortujuan" placeholder="nomor telpon tujuan" autofocus>
                        <button type="submit" class="btn btn-rounded bg-template" onclick="kirimSaldo()">
                            <span class="material-icons">send</span>
                        </button>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/transfer.js" defer></script>
<?= $this->endSection('content'); ?>

<div class="card shadow border-0 mb-3">
    <div class="card-body">
        <div class="row h-100">
            <!-- <div class="col-auto pr-0">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-success"></div>
                        <i class="material-icons text-success md-36">person</i>
                    </div>
                </div> -->
            <div class="col">
                <h3><span class="text-template">Rp 2.000</span> <small class="text-mute text-secondary">Paket Harian</small></h3>
                <ul class="list pl-4 my-3">
                    <li>1000mL</li>
                    <li>Pembayaran hanya dapat melalui Gopay / QRIS</li>
                    <li>Sudah termasuk pajak</li>
                </ul>
                <form class="vocer" method="POST" action="/snap">
                    <input type="hidden" class="form-control" id="id" name="id" value="1000mL">
                    <input type="hidden" class="form-control" id="paket" name="paket" value="Paket Harian">
                    <input type="hidden" class="form-control" id="harga" name="harga" value="2000">
                    <button type="submit" class="mb-2 btn btn-outline btn-rounded bg-template">Beli</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card shadow border-0 mb-3">
    <div class="card-body">
        <div class="row h-100">
            <!-- <div class="col-auto pr-0">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-danger"></div>
                        <i class="material-icons text-danger md-36">cloud</i>
                    </div>
                </div> -->
            <div class="col">
                <h3><span class="text-template">Rp 10.000</span><small class="text-mute text-secondary">Paket Hemat</small></h3>
                <ul class="list pl-4 my-3">
                    <li>5.000mL</li>
                    <li>sudah termasuk pajak</li>
                </ul>
                <form class="vocer" method="POST" action="/snap">
                    <input type="hidden" class="form-control" id="id" name="id" value="5.000mL">
                    <input type="hidden" class="form-control" id="paket" name="paket" value="Paket Hemat">
                    <input type="hidden" class="form-control" id="harga" name="harga" value="10000">
                    <button type="submit" class="mb-2 btn btn-rounded bg-template">Beli</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card shadow border-0 mb-3">
    <div class="card-body">
        <div class="row h-100">
            <!-- <div class="col-auto pr-0">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay gradient-info"></div>
                        <i class="material-icons text-info md-36">airplanemode_active</i>
                    </div>
                </div> -->
            <div class="col">
                <h3><span class="text-template">Rp 25.000</span><small class="text-mute text-secondary">Paket Besar</small></h3>
                <ul class="list pl-4 my-3">
                    <li>12500mL</li>
                    <li>Sudah termasuk pajak</li>
                </ul>
                <form class="vocer" method="POST" action="/snap">
                    <input type="hidden" class="form-control" id="id" name="id" value="12.500mL">
                    <input type="hidden" class="form-control" id="paket" name="paket" value="Paket Besar">
                    <input type="hidden" class="form-control" id="harga" name="harga" value="25000">
                    <button type="submit" class="mb-2 btn bg-template  btn-rounded">Beli</button>
                </form>
            </div>
        </div>
    </div>
</div>