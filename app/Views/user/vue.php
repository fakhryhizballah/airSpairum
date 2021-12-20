<?= $this->extend('/layout/user_template'); ?>
<?= $this->section('content'); ?>
<div id="app">
    <!-- <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream> -->
    <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit"></qrcode-stream>

    <p class="decode-result">Last result: <b>{{ result }}</b></p>
    <button v-on:click="greet">Greet</button>
</div>
<button onclick="myFunction()">try</button>
<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://unpkg.com/vue-qrcode-reader/dist/VueQrcodeReader.umd.min.js"></script>
<script>
    function myFunction() {
        // document.getElementsByTagName("app").replaceWith("element");
        document.getElementsByTagName("qrcode-stream").replaceChild("element");
    }
    new Vue({
        el: '#app',

        data() {
            return {
                camera: 'off',
                result: null,
            }
        },

        methods: {
            onDecode(url) {
                // window.location.href = url
                console.log(url)

                this.turnCameraOff()
                this.result = url

            },

            onInit(promise) {
                promise
                    .then(console.log)
                    .catch(console.error)
            },

            turnCameraOff() {
                this.camera = 'off'
            },

            greet: function(event) {
                // `this` inside methods points to the Vue instance
                this.camera = 'auto'
            }
        }

    })
    // new Vue({
    //     el: '#app',
    //     methods: {
    //         onDecode(url) {
    //             // window.location.href = url
    //             console.log(url)
    //             this.turnCameraOff()

    //         },
    //         async onInit(promise) {
    //             // show loading indicator

    //             try {
    //                 const {
    //                     capabilities
    //                 } = await promise

    //                 // successfully initialized
    //             } catch (error) {
    //                 if (error.name === 'NotAllowedError') {
    //                     // user denied camera access permisson
    //                 } else if (error.name === 'NotFoundError') {
    //                     // no suitable camera device installed
    //                 } else if (error.name === 'NotSupportedError') {
    //                     // page is not served over HTTPS (or localhost)
    //                 } else if (error.name === 'NotReadableError') {
    //                     // maybe camera is already in use
    //                 } else if (error.name === 'OverconstrainedError') {
    //                     // did you requested the front camera although there is none?
    //                 } else if (error.name === 'StreamApiNotSupportedError') {
    //                     // browser seems to be lacking features
    //                 }
    //             } finally {
    //                 // hide loading indicator
    //             }
    //         }
    //     }
    // })
</script>

<?= $this->endSection('script'); ?>