<?= $this->extend('layout/user_template'); ?>

<?= $this->section('head'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- <link href="/css/maps.css" rel="stylesheet"> -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
<style>
    #map {
        position: absolute;
        height: 100%;
        width: 100%;
    }
</style>
<script src="https://js.sentry-cdn.com/9c5feb5b248b49f79a585804c259febc.min.js" crossorigin="anonymous"></script>
</head>
<?= $this->endSection('head'); ?>

<?= $this->section('content'); ?>

<div class="map">
    <div id="map"></div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src=/js/maps.js> </script>
<!-- <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css"> -->
<script>

</script>
<?= $this->endSection('script'); ?>