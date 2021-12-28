// sweet alern 2
const swal = $(".swal").data("swal");
if (swal) {
    Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: swal,
        confirmButtonText: 'Oke'
    })
}
const flashData = $(".flash-data").data("flashdata");
// cek console
// console.log(flashData);
if (flashData) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4500,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: flashData,
    })
}
const flashError = $(".flash-Error").data("flashdata");
console.log(flashError);
if (flashError) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: flashError,
    })
}
const flashSuccess = $(".flash-Success").data("flashdata");
console.log(flashSuccess);
if (flashSuccess) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: flashSuccess,
    })
}

const currentLocation = location.href;
const menuItem = document.querySelectorAll('.item');
const menuLength = menuItem.length
for (let i = 0; i < menuLength; i++) {
    if (menuItem[i].href === currentLocation) {
        menuItem[i].className = "btn btn-link-default active"
    }
}

// PWA 

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
        .then(function (registration) {
            console.log('Registration successful, scope is:', registration.scope);
        })
        .catch(function (error) {
            console.log('Service worker registration failed, error:', error);
        });
}