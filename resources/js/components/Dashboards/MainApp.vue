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
                    <template v-if="env.IS_ADMIN">
                        <home-admin></home-admin>
                    </template>
                    <template v-else-if="env.IS_SISWA">
                        <home-siswa></home-siswa>
                    </template>
                    <template v-else>
                        <p>Loading ...{{ env.IS_ADMIN }} ... {{ env.IS_SISWA }}</p>
                    </template>
                </div>
            </section>
        </div>
        <footer></footer>
    </div>
  </div>
</template>
<script>
    import Master from './../Layouts/Master'
    import Footer from './../Layouts/Footer'

    import HomeAdmin from './Admin/Home'
    import HomeSiswa from './Siswa/Home'

    export default {
        data() {
            return {
                env: {
                    TOKEN: localStorage.getItem('token'),
                    IS_SISWA: null,
                    IS_ADMIN: null,
                    BRAND: 'SI PKL',
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
            axios.defaults.headers.common = {
               'Accept': 'application/json',
               'Authorization': `Bearer ${this.env.TOKEN}`,
            }
            this.user.name = this.env.USER?.name || 'bro'
            this.user.name = this.user.name.split` `.map(v => v.charAt(0).toUpperCase() + v.slice(1)).join` ` || 'bro'
            this.setUcapan()
            this.checkToken()
            this.getUser()
        },
        methods: {
            checkToken() {
                axios.get(`/api/v1/check`)
                    .then(res => {
                        // no action here
                    }).catch(e => {
                        this.$router.push({
                            name: 'login',
                            query: { redirect: location.pathname.split`/`[1] },
                        })
                    })
            },

            getUser() {
                axios.get('/api/v1/getuser')
                    .then(res => {
                        let { user, siswa } = res.data.data
                        this.setRole(user.role)
                        this.user.data = this.user.role == 'siswa' ? { ...siswa } : { ...user }
                     }).catch(e => console.log(e))
            },

            setUcapan() {
                this.env.UCAPAN = `Selamat ${((this.env.TIME.hours >= 4 ) && (this.env.TIME.hours < 10)) ? 'Pagi' : ((this.env.TIME.hours >= 10 && this.env.TIME.hours < 15) ? 'Siang' : ((this.env.TIME.hours >= 15 && this.env.TIME.hours < 18) ? 'Sore' : (this.env.TIME.hours >= 18 || this.env.TIME.hours < 4) ? 'Malam' : ''))}, ${this.user.name}`
                this.$root.$on('loggedIn', ({ user }) => {
                    this.$toasted.global.success({ message: this.env.UCAPAN })
                })
//                this.env.UCAPAN = 'Selamat ' + ((this.env.TIME.hours >= 4 ) && (this.env.TIME.hours < 10)) ? `Pagi ${this.env.TIME.hours}` : ((this.env.TIME.hours >= 10 && this.env.TIME.hours < 15) ? 'Siang' : ((this.env.TIME.hours >= 15 && this.env.TIME.hours < 18) ? 'Sore' : (this.env.TIME.hours >= 18 || this.env.TIME.hours < 4) ? 'Malam' : '')) + ', ' + this.user.name
            },
            setRole(role) {
                this.env.IS_SISWA = (role == 'siswa') ? true : false
                this.env.IS_ADMIN = (role == 'pembimbing' && role != 'siswa') ? true : false
                this.user.role = role
            },
        },
 
        components: { Master, Footer, HomeAdmin, HomeSiswa }
    }
</script>
