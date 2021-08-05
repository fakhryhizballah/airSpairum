<meta name="viewport" content="width=device-width, initial-scale=1">
<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <h6 class="subtitle">Konfirmasi Pembayaran</h6>
    <div class="card shadow border-0 mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="font-weight-normal mb-1">Rp <?php echo $harga; ?> </h5>
                    <p class="text-mute small text-secondary mb-2">Tipe Paket <?php echo $paket; ?></p>
                    <div class="text-mute small text-secondary mb-2" id="result_id"></div>
                    <p class="text-mute small text-secondary mb-2">Token: <?php echo $snapToken; ?></p>
                </div>
                <div class="col-auto pl-0">
                    <button id="pay-button" class="mb-2 btn btn-outline-primary btn-rounded">
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- <button id="pay-button">Pay!</button> -->
<!-- <pre><div id="result-json"><br></div></pre> -->




<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->

<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-OpIVj-JDdg9BEE2o"></script> -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-OpIVj-JDdg9BEE2o"></script>
<!-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-OpIVj-JDdg9BEE2o"></script> -->
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        // SnapToken acquired from previous step
        console.log("Beli");
        snap.pay('<?php echo $snapToken ?>', {
            // Optional
            // onSuccess: function(result) {
            //     /* You may add your own js here, this is just example */
            //     document.getElementById('result-json').innerHTML += JSON.stringify(result.order_id);
            // },
            // // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log("Belum Bayar");
            },
            // // Optional
            // onError: function(result) {
            //     /* You may add your own js here, this is just example */
            //     document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            // }

        });

    };
</script>
<?= $this->endSection('content'); ?>