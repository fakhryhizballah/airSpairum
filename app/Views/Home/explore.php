<?= $this->extend('layout/templateBack'); ?>
<?= $this->section('MainBack'); ?>

<div class="countainer">
    <div class="map"></div>
</div>

<div id="map"></div>

<script>
    var map, infoWindow;
    // <div id="mapid" style="width: 600px; height: 400px;"></div>
    var mymap = L.map('map').setView([-0.024779, 109.328607], 15);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {

        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',

    }).addTo(mymap);

    <?php foreach ($stasiun as $key => $value) { ?>
        L.marker([<?= $value['lat']; ?>, <?= $value['lng']; ?>]).addTo(mymap).bindPopup("<b><?= $value['lokasi']; ?></b><br /> Isi <?= $value['isi']; ?> mL. <br><a href='<?= $value['link']; ?> '>Buka Maps</a>");
    <?php } ?>
</script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjKeVFWsG5gTOd4UegCxqJgKoRam9yJX0&callback=initMap">
</script>

<!-- <?php foreach ($stasiun as $s) : ?>
    <div class="card card-iden shadow">
        <h5 class="card-iden-h5"><?= $s['lokasi']; ?></h5>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Kordinat</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['lat']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">ID Mesin</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['id_mesin']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Isi Air dalam Stasiun</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['isi']; ?> mL</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Indikator</p>
            </div>
            <div class="col">
                <p class="card-iden-p2"><?= $s['indikator']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Status</p>
            </div>
            <div class="col">

                <h1 class="card-iden-p2 text-muted">
                    <?php
                    if ($s['status'] == '1') {
                        echo "stanbay";
                    } elseif ($s['status']  == '2') {
                        echo "Sedang proses pengisian";
                    } else {
                        echo "Off";
                    }
                    ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="card-iden-p1">Update Time</p>
            </div>
            <div class="col">
                <p class="card-iden-p2 text-muted"><?= $s['updated_at']; ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?> -->


<?= $this->endSection('MainBack'); ?>