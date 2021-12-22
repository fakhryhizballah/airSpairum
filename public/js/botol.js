// $('#modal-addBotol').modal({ backdrop: 'static' })
function addBotol() {
    $('#modal-addBotol').modal('show');

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview2'),
        scanPeriod: 1,
        mirror: false
    });

    scanner.addListener('scan', function (content, image) {
        $("#code").val(content);
        var formData = {
            id_botol: content,
        };
        console.log(content);
        $.ajax({
            type: "POST",
            url: "/addBotol/addBotol",
            data: formData,
            dataType: "json",
            encode: true,
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Salah QRs',
                });
            },
        }).done(function (response) {
            Swal.fire({
                icon: response.icon,
                title: response.status,
                text: response.message,
                confirmButtonText: 'Oke',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#modal-addBotol').modal('hide');
                    document.location.reload(true)
                }
            });
        });
    });

    // return window.location = route;
    Instascan.Camera.getCameras().then(function (cameras) {
        console.log(cameras);

        if (cameras.length > 0) {
            scanner.start(cameras[0]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != "") {
                        scanner.start(cameras[0]);
                    } else {
                        alert('No Front camera found!');
                    }
                } else if ($(this).val() == 2) {
                    if (cameras[1] != "") {
                        scanner.start(cameras[1]);
                    } else {
                        alert('No Back camera found!');
                    }
                }
            });
            console.log(activeCameraId.name);


            isQRScannerInitialised = true;

        } else {

            alert('No cameras found.');
            console.error('No cameras found.');
            isQRScannerInitialised = false;
            return;
        }
    }).catch(function (e) {
        console.error(e);
    });
    isQRScannerInitialised = false;

    console.log('Show Modal');

    $('#modal-addBotol').on('hidden.bs.modal', function () {
        console.log('close Modal');
        scanner.stop();
    })

}
function hapusbtol(id) {
    Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Botol akan menghilang di akun mu setelah kamu hapus!!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya Hapus',
        cancelButtonText: 'Gak Jadi',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                data: {
                    id_botol: id
                },
                dataType: "json",
                success: function (response) {
                    Swal.fire({
                        icon: response.icon,
                        title: response.status,
                        text: response.message,
                        confirmButtonText: 'Oke',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            document.location.reload(true)
                        }
                    });

                },
                url: "/addBotol/delBotol",
            })
        }
    })

}
