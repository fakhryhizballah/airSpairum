function scane() {
    $('#modal-pindai').modal('show');

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        scanPeriod: 1,
        mirror: false
    });

    scanner.addListener('scan', function (content, image) {
        $("#code").val(content);
        var name = content.split('/')[5]
        // console.log(name);
        if (name == undefined) {
            mesin_id = content;
        } else {
            mesin_id = name;
        }
        // document.getElementById("take").submit();
        var formData = {
            myRange: $("#myRange").val(),
            // code: $("#code").val(),
            code: mesin_id,
        };
        console.log(formData);
        $('#modal-pindai').modal('hide');
        Swal.showLoading()
        $.ajax({
            type: "POST",
            url: "/Ajax/index",
            data: formData,
            dataType: "json",
            encode: true,
            error: function (data) {
                // console.log(data);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Salah QR',
                });
            },
        }).done(function (data) {
            console.log(data);
            take(data);
            $('#modal-pindai').modal('hide');
        })
    });

    // return window.location = route;
    Instascan.Camera.getCameras().then(function (cameras) {
        console.log(cameras);
        // alert(JSON.stringify(cameras));
        if (cameras.length > 0) {
            if (cameras[2] != undefined) {
                scanner.start(cameras[2]);
            } else if (cameras[1] != undefined) {
                scanner.start(cameras[1]);
            } else {
                scanner.start(cameras[0]);
            }
            // scanner.start(cameras[1]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != undefined) {
                        scanner.start(cameras[0]);
                    } else {
                        alert('No Front camera found!');
                    }
                } else if ($(this).val() == 2) {
                    if (cameras[1] != undefined) {
                        scanner.start(cameras[1]);
                    } else {
                        alert('No Back camera found!');
                    }
                }
            });
            // console.log(activeCameraId.name);


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

    $('#modal-pindai').on('hidden.bs.modal', function () {
        console.log('close Modal');
        scanner.stop();
    })
}

// const socket = io("https://socket.spairum.my.id:3000", {
const url = document.getElementById("socket");
const socket = io(url.value, {
    // withCredentials: true,
    // extraHeaders: {
        // "my-custom-header": "abcd"
    // }
});
socket.on("connect", () => {
    console.log(socket.id); // x8WIv7-mJelg7on_ALbx
    socket.on("pesan", (arg) => {
        console.log(arg); // world
    });
});
function take(data) {
    if (data.status == '200') {
        if (data.status_mesin == 'Offline') {
            Swal.fire({
                icon: 'warning',
                title: 'Maaf dalam perbaikan',
                text: "Mohon Maaf Stasiun Spairum dalam perbaikan",
                footer: '<a href="https://wa.me/+6289601207398">Hubungi admin? klik di sini</a>',
                confirmButtonText: 'Baik'
            })
            return;
        }
        Swal.fire({
            title: "Membeli " + data['nama'],
            text: "Harga " + data['harga'] +
                "/100mL ",
            footer: "total " + "=" +
                " Rp" + data['total'],
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ambil Air',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('ambil');
                $.ajax({
                    type: "post",
                    data: data,
                    dataType: "json",
                    url: "/Ajax/PushAir",
                    error: function (e) {
                        console.log("error");
                        console.log(e);
                    },
                    success: function (response) {
                        console.log(response);
                        const obj = JSON.parse(response);
                        console.log(obj);
                        console.log(obj.akun);
                        let timerInterval
                        Swal.fire({
                            title: 'Sedang Megisi',
                            // html: 'I will close in <b></b> milliseconds.',
                            // timer: 20000,
                            text: "jika ingin meghntikan klik stop",
                            // timerProgressBar: true,
                            showCancelButton: true,
                            cancelButtonText: 'STOP',
                            cancelButtonColor: '#be4d25',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                                // const b = Swal.getHtmlContainer().querySelector('b')
                                // timerInterval = setInterval(() => {
                                //     b.textContent = Swal.getTimerLeft()
                                // }, 100)
                                socket.on("current/" + obj.akun, (msg) => {
                                    console.log(msg);
                                    // console.log(msg.Status);
                                    // b.textContent = msg.Status
                                    if (msg.Status == "Selesai") {
                                        Swal.close()

                                    }
                                });
                            },
                            willClose: () => {
                                console.log('Stop Air')
                                console.log(data)
                                Swal.fire('stop', '', 'success')
                                $.ajax({
                                    type: "post",
                                    data: data,
                                    dataType: "json",
                                    url: "/Ajax/stopAir",
                                    error: function (e) {
                                        console.log("error");
                                        console.log(e);
                                    },
                                    success: function (response) {
                                        console.log("stop sukses");
                                        console.log(response);
                                    }


                                })
                                getSaldo();
                            }

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.dismiss) {
                                console.log('dismiss')
                                // document.location.reload(true)

                            }
                        })

                        console.log('PuSH');

                    },

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