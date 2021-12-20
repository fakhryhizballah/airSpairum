// $('#modal-addBotol').modal({ backdrop: 'static' })

function addBotol() {
    $('#modal-addBotol').modal('show');
    new Vue({
        el: '#app',
        data() {
            return {
                camera: 'Back',

                noRearCamera: false,
                noFrontCamera: false
            }
        },
        methods: {
            switchCamera() {
                switch (this.camera) {
                    case 'front':
                        this.camera = 'rear'
                        break
                    case 'rear':
                        this.camera = 'front'
                        break
                }
            },
            onDecode(url) {
                // window.location.href = url
                console.log(url)
                var formData = {
                    id_botol: url,
                };
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
                    console.log(response);

                })
                this.turnCameraOff()
                // $('#modal-addBotol').modal('hide');
                // document.location.reload(true)

                this.result = url

            },

            async onInit(promise) {
                try {
                    await promise
                    console.log(capabilities)
                    alert(capabilities)
                    // this.error = promise
                } catch (error) {
                    if (error.name === 'NotAllowedError') {
                        this.error = "ERROR: you need to grant camera access permission"
                    } else if (error.name === 'NotFoundError') {
                        this.error = "ERROR: no camera on this device"
                    } else if (error.name === 'NotSupportedError') {
                        this.error = "ERROR: secure context required (HTTPS, localhost)"
                    } else if (error.name === 'NotReadableError') {
                        this.error = "ERROR: is the camera already in use?"
                    } else if (error.name === 'OverconstrainedError') {
                        this.error = "ERROR: installed cameras are not suitable"
                    } else if (error.name === 'StreamApiNotSupportedError') {
                        this.error = "ERROR: Stream API is not supported in this browser"
                    } else if (error.name === 'InsecureContextError') {
                        this.error = 'ERROR: Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.';
                    } else {
                        this.error = `ERROR: Camera error (${error.name})`;
                    }
                    const triedFrontCamera = this.camera === 'front'
                    const triedRearCamera = this.camera === 'rear'

                    const cameraMissingError = error.name === 'OverconstrainedError'

                    if (triedRearCamera && cameraMissingError) {
                        this.noRearCamera = true
                    }

                    if (triedFrontCamera && cameraMissingError) {
                        this.noFrontCamera = true
                    }

                    console.error(error)
                }
                $('#modal-addBotol').on('hidden.bs.modal', function () {
                    console.log("ssaas")
                    document.location.reload(true)
                })
            },

            turnCameraOff() {
                this.camera = 'off'
            },

            greet: function (event) {
                // `this` inside methods points to the Vue instance
                this.camera = 'auto'
            },
        },

    })
    $('#modal-pindai').on('hidden.bs.modal', function () {
        console.log('close Modal');
        // scanner.stop();
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
