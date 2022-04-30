async function kirimSaldo() {
    // document.getElementById("demo").innerHTML = "Hello World";
    const nominal = document.querySelector('#nominal').value
    const nomortujuan = document.querySelector('#nomortujuan').value
    if (!nominal || !nomortujuan) {
        Swal.fire('Oops', 'Nominal dan Nomor Tujuan harus diisi', 'error');
        return;
    }
    let FormData = {
        nominal,
        nomortujuan
    };
    let response = await fetch('/Saldo/cekUser', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify(FormData),
        dataType: "json",
    });
    let data = await response.json();
    if (data.status == 'error') {
        Swal.fire('Oops', data.message, 'error');
        return;
    } else {
        Swal.fire({
            title: 'Apakah anda yakin ingin berbagi saldo ini?',
            html: 'Nama: ' + data.nama + '<br>' +
                'Nominal: ' + nominal + '<br>' +
                'Nomor Tujuan: ' + nomortujuan,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'kirim'
        }).then((result) => {
            if (result.isConfirmed) {
                return fetch('/Saldo/kirimSaldo', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify(data),
                    dataType: "json",
                }).then(response => {
                    if (!response.status) {
                        throw new Error(response.statusText)
                    }
                    return (response.json()).then(data => {
                        if (data.status == 'error') {
                            Swal.fire('Oops', data.message, 'error');
                            return;
                        } else {
                            Swal.fire('Berhasil', data.message, 'success');
                            return window.location.reload();
                        }

                    })
                });
            }
        })
    }
}