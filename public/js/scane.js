function scane() {
    $('#modal-pindai').modal('show');

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });

    scanner.addListener('scan', function(content, image) {
        $("#code").val(content);
        // console.log(content);
        // document.getElementById("take").submit();
        var formData = {
            myRange: $("#myRange").val(),
            code: $("#code").val(),
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "/Ajax/index",
            data: formData,
            dataType: "json",
            encode: true,
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Salah QR',
                });
            },
        }).done(function(data) {
            console.log(data);
            take(data);

            $('#modal-pindai').modal('hide');
        })
    });

    // return window.location = route;

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
    });

    console.log('Show Modal');

    $('#modal-pindai').on('hidden.bs.modal', function() {
        console.log('close Modal');
        scanner.stop();
    })
}


function take(data) {
    if (data.status == '200') {
        Swal.fire({
            title: "Membeli " + data['nama'],
            text: "Harga " + data['harga'] +
                "/100mL ",
            footer: "total " + data['harga'] + "x" + data['diambil'] + "=" +
                " Rp" + data['total'],
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ambil Air'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('ambil');
                $.ajax({
                    type: "post",
                    data: data,
                    dataType: "json",
                    // url: "<?php echo site_url('/TransMqtt/PushAir'); ?>",
                    url: "/Ajax/PushAir",
                    success: function(response) {
                        console.log(response);
                        const ws = new WebSocket("wss://apptes.spairum.my.id:3000");
                        ws.addEventListener("open", function open() {
                            ws.send('Hello Server!');
                            console.log("Terhubung");
                        });
                        ws.addEventListener('message', function incoming(current) {
                            console.log(current.data);
                            var obj = JSON.parse(current.data);
                            console.log(obj.id_user);
                            console.log(response.id_user);
                            if (obj.id_user == response.id_user) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Permintaan sedang di proses',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        });
                        ws.addEventListener('close', (event) => {
                            console.log('The connection has been closed successfully.');
                        });
                        console.log(response);
                        console.log('PuSH');

                    }
                })

            }
        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Saldo anda tidak cukup kurang",
            footer: '<a href="/topup">Silahkan isi saldo dulu</a>'
        })
    }
}