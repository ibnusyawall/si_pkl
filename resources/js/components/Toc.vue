<template>
    <div>
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            {{ env.BRAND }}
                        </div>

                        <div class="card card-primary">
                            <div class="card-header"><h4>Term and Conditions</h4></div>

                            <div class="card-body">
                                <h6><b>Ketentuan Layanan</b></h6><br>
                                <p>
                                    1. Kami berhak memverifikasi atau tidak memverifikasi akun yang sudah anda daftarkan sebelumnya.<br>
                                    2. Kami berhak menghapus data sekolah bersamaan dengan data siswa yang dikaitkan dengan sekolah tersebut dikarenakan alasan tertentu. <br>
                                    3. Kami berhak mengubah dan menghapus data siswa maupun sekolah tanpa pemberitahuan sebelumnya dikarenakan kekeliruan data atau alasan tertentu. Jika dirasa penting, akan kami beritahukan melalui e-mail konfirmasi maupun kontak informasi siswa maupun pembimbing.
                                </p><br><br>
                                <h6><b>Privasi dan Keamanan</b></h6><br>
                                <p>
                                    1. Kami menjamin keamanan data pribadi Anda yang menggunakan layanan <i>sipkl</i>.<br>
                                    2. Semua informasi pribadi Anda kami lindungi sepenuhnya. Kerahasiaan informasi yang anda masukan dalam <i>sipkl</i> akan kami jaga baik-baik untuk kepentingan Anda.<br>
                                    3. <i>sipkl</i> dapat mengubah dan memperbarui syarat dan ketentuan situs ini sewaktu-waktu. Kami akan memberitahu perubahan-perubahan tersebut di situs dan email jika dirasa perlu. Perubahan dari syarat dan ketentuan akan berlaku segera setelah dimasukan kedalam situs.
                                </p><br><br>
                                <h6><b>Keluhan atau Pertanyaan</b></h6><br>
                                <p>
                                    Bila Anda memiliki pertanyaan atau keluhan, Anda dapat menghubungi kami via whatsapp di <a style="text-decorative: none;" :href="contact.link">{{ contact.text }}</a>
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 text-muted text-center">
                            <router-link :to="$route.query.back">Kembali</router-link>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; {{ env.APP_NAME }} {{ env.DATE_YEARS }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { required, email, minLength } from 'vuelidate/lib/validators'
    import moment from 'moment-timezone'
    export default {
        data() {
            return {
                user: {
                    email: '',
                    pass: '',
                },
                user_r: [],
                env: {
                    BRAND: 'SIPKL',
                    APP_NAME: 'SI PKL STMIK AKAKOM',
                    DATE_YEARS: new Date().getUTCFullYear(),
                },
                error: {
                    status: '',
                    email: '',
                    pass: '',
                },
                contact: {
                    link: 'https://wa.me/6282299265151',
                    text: 'SYAWALTECH',
                },
                time: '',
                isregister: !!localStorage.getItem('registered'),
                refcount: 0,
                isLoading: false,
                nonverified: false,
            }
        },

        validations: {
            user: {
                email: { required, email, },
                pass: { required, minLength: minLength(4), },
            },
        },

        /*emits: {
            loggedIn: {}
        },*/

        mounted() {
            const timer = window.setTimeout(this.getTime, 1000)
            this.$on('hook:destroyed', () => window.clearTimeout(timer))
        },

        methods: {
            registered(user) {
                this.isregister = true
                this.user_r.push(user)
                console.log(user)
            },
            submit() {
                this.$v.$touch()
                if (this.$v.$invalid) return
                axios.post('/api/oauth/login', { email: this.user.email, password: this.user.pass })
                    .then(res => {
                        let { users, token } = res.data.data

                        if (users?.status == 'unverified') {
                            setTimeout(() => {
                                this.nonverified = true
                            }, 1000)
                        } else {

                            this.setToken(token, users)
                            this.$toasted.global.success({ message: 'Berhasil login, sedang dialihkan.' })
                            this.$parent.$emit('loggedIn', { user: users })
                            window.location = this.$router.resolve({ name: 'dashboard-home' }).href
                        }
                    }).catch(e => {
                        this.error.status = e.response.data.data.error
                        this.error.status = this.error.status.split` `.map(v => v.charAt(0).toUpperCase() + v.slice(1)).join` `.replace('.', ' ')
                        this.$toasted.global.error({ message: 'Email dan password salah.' })
                        console.log(e.response.data.data.error)
                    })
            },

            setToken(token, users) {
                localStorage.setItem('users', JSON.stringify(users))
                localStorage.setItem('token', token)
            },

            rclose() {
                localStorage.removeItem('registered')
            },

            sclose() {
                this.nonverified = false
            },

            setLoading(isLoading) {
                if (isLoading) {
                    this.refcount++
                    this.isLoading = true
                } else if (this.refcount > 0) {
                    this.refcount--
                    this.isLoading = (this.refcount > 0)
                }
            },

            getTime(){
                this.time = moment().format('HH:mm:ss')
                window.setTimeout(this.getTime, 1000)
            }
        },

        created() {
            axios.interceptors.request.use((config) => {
                this.setLoading(true)
                return config
            }, (error) => {
                this.setLoading(false)
                return Promise.reject(error)
            })

            axios.interceptors.response.use((response) => {
                this.setLoading(false)
                return response
            }, (error) => {
                this.setLoading(false)
                return Promise.reject(error)
            })
        },
    }
</script>
