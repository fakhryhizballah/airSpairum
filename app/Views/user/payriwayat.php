<?= $this->extend('layout/user_template'); ?>
<?= $this->section('content'); ?>

<!-- page content here -->
<div class="container">
    <h6 class="subtitle">lihat History pembayaran<a href="/riwayat"><br>History Pengambilan Air</a></h6>
</div>
<div class="row">
    <div class="col-12 px-0">
        <ul class="list-group list-group-flush border-top border-bottom">
            <?php foreach ($history as $r) : ?>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto pr-0">
                            <!-- <div class="avatar avatar-50 no-shadow border-0">
                                <img src="img/user3.png" alt="">
                            </div> -->
                        </div>
                        <?php $status = $r['status'];
                        $Payment_Code = $r['Payment_Code'];
                        $Order_id = $r['order_id'];
                        $Merchant_Code = $r['Merchant_Code'];
                        $va_code = $r['va_code'];
                        $Biller_Code = $r['Biller_Code'];
                        $Bill_Key = $r['Bill_Key'];
                        $Product_Code = $r['Product_Code'];
                        $User_Id = $r['User_Id'];
                        ?>
                        <div class="col align-self-center ">
                            <h6 class="font-weight-normal mb-1">Top Up Rp.<?= $r['harga']; ?></h6>
                            <h3 class="text-mute small text-secondary">Metode pembayaran melalui <?= $r['bank']; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['order_id']) ? "Order id:  $Order_id"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['Payment_Code']) ? "Payment Code:  $Payment_Code"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['Merchant_Code']) ? "Merchant Code:  $Merchant_Code"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['va_code']) ? "Virtual Account Number:  $va_code"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['Biller_Code']) ? "Biller Code:  $Biller_Code"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['Bill_Key']) ? "Bill Key:  $Bill_Key"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['Product_Code']) ? "Product Code:  $Product_Code"  : ""; ?></h3>
                            <h3 class="text-mute small text-secondary"><?php echo isset($r['User_Id']) ? "User Id:  $User_Id"  : ""; ?></h3>

                            <h3 class="text-mute small text-secondary"><?= $r['created_at']; ?></h3>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-success">Status</h6>
                            <h6 class="text-success"><strong><?php echo isset($r['status']) ? "$status"  : ""; ?> </strong></h6>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- page content ends -->

<?= $this->endSection('content'); ?>