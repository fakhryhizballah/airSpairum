<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card fixed-top">
    <div class="row no-gutters">
        <div class="col-1">
            <a href="javascript:window.history.go(-1);">
                <img class="back" src="/img/back.png" alt="">
            </a>
        </div>
        <div class="col-10 text-center">
            <h5 class="h5-navbar"><?= $page; ?></h5>
        </div>
    </div>
</div>
<!-- <div class="view-back"> -->
<?= $this->renderSection('MainBack'); ?>
<!-- </div> -->
<?= $this->endSection('content'); ?>