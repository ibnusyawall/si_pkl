<template>
  <div>
    <div class="main-wrapper main-wrapper-1">
        <master></master>
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>{{ env.UCAPAN }}</h1>
                </div>

                <div class="section-body">
                    <manage-sekolah></manage-sekolah>
                </div>
            </section>
        </div>
    </div>
  </div>
</template>
<script>
    import Master from './../../Layouts/Master'
    import ManageSekolah from './src/ManageSekolah'

    export default {
        data() {
            return {
                env: {
                    UCAPAN: '',
                    USER: JSON.parse(localStorage.getItem('users')),
                    TIME: { hours: new Date().getHours(), }
                },
                user: {
                    name: '',
                },
            }
        },

        beforeMount() {
            this.user.name = this.env.USER?.name || 'bro'
            this.user.name = this.user.name.split` `.map(v => v.charAt(0).toUpperCase() + v.slice(1)).join` ` || 'bro'
            this.setUcapan()
        },

        methods: {
            setUcapan() {
                this.env.UCAPAN = `Selamat ${((this.env.TIME.hours >= 4 ) && (this.env.TIME.hours < 10)) ? 'Pagi' : ((this.env.TIME.hours >= 10 && this.env.TIME.hours < 15) ? 'Siang' : ((this.env.TIME.hours >= 15 && this.env.TIME.hours < 18) ? 'Sore' : (this.env.TIME.hours >= 18 || this.env.TIME.hours < 4) ? 'Malam' : ''))}, ${this.user.name}`
            },
        },

        components: { Master, ManageSekolah }
    }
</script>
