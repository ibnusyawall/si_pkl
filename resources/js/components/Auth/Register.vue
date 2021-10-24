<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            {{ env.BRAND }}
                        </div>

                        <div class="card card-primary">
                            <div class="card-header"><h4>Register</h4></div>

                            <div class="card-body">
                                <div v-if="!!errorTab.length" class="alert alert-info alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert" v-on:click="sclose">
                                            <span>×</span>
                                        </button>
                                        <ul v-for="v in errorTab">
                                            <li>{{ v.email }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <form @submit.prevent="submit">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="email">Email</label>
                                            <input
                                                id="email"
                                                type="email"
                                                :class="$v.user.email.$error ? 'form-control is-invalid' : 'form-control'"
                                                v-model.trim="$v.user.email.$model"
                                                autofocus
                                                required
                                            >
                                            <div class="invalid-feedback">Email
                                                {{
                                                   $v.user.email.$error ?
                                                   (!$v.user.email.required ? 'is required' : 
                                                    !$v.user.email.email ? 'is invalid' : '' 
                                                   ) :
                                                   ''
                                                }}
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="pass">Password</label>
                                            <input
                                                id="pass"
                                                type="password"
                                                :class="$v.user.pass.$error ? 'form-control is-invalid' : 'form-control'"
                                                v-model.trim="$v.user.pass.$model"
                                                required
                                            >
                                            <div class="invalid-feedback">Password
                                                {{
                                                   $v.user.pass.$error ?
                                                   (!$v.user.pass.required ? 'is required' :
                                                    !$v.user.pass.minLength ? 'must be at least 6 characters' : ''
                                                   ) :
                                                   ''
                                                }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input
                                                id="nama"
                                                type="text"
                                                :class="$v.user.name.$error ? 'form-control is-invalid' : 'form-control'"
                                                v-model.trim="$v.user.name.$model"
                                                required
                                            >
                                            <div class="invalid-feedback">Nama
                                                {{ $v.user.name.$error ? (!$v.user.name.required ? 'is required' : '') : '' }}
                                            </div>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Jenis Kelamin</label>
                                            <select class="form-control selectric" v-model="user.jenis_kelamin">
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Sekolah</label>
                                            <select class="form-control selectric" v-model="user.sekolah_id">
                                                <option v-for="v in npsnCollect" :value="v.npsn">{{ v.nama }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="jurusan" class="d-block">Jurusan</label>
                                            <input
                                                id="jurusan"
                                                type="text"
                                                :class="$v.user.jurusan.$error ? 'form-control is-invalid' : 'form-control'"
                                                v-model="$v.user.jurusan.$model"
                                                required
                                            >
                                            <div class="invalid-feedback">Jurusan
                                                {{ $v.user.jurusan.$error ? (!$v.user.jurusan.required ? 'is required' : '') : '' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input
                                            id="nis"
                                            type="number"
                                            :class="$v.user.nis.$error ? 'form-control is-invalid' : 'form-control'"
                                            v-model="$v.user.nis.$model"
                                            required
                                        >
                                        <div class="invalid-feedback">NIS
                                            {{ $v.user.nis.$error ? (!$v.user.nis.required ? 'is required' : '') : '' }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="agree" class="custom-control-input" id="agree" required>
                                            <label class="custom-control-label" for="agree">I agree with the <router-link :to="{ name: 'toc', query: { back: $route.fullPath } }">terms and conditions</router-link></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-lg btn-block"
                                            :disabled="!agree || $v.$invalid || isLoading || !check(user)"
                                        >{{ isLoading ? `wait...` : 'Register' }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Have account? <router-link :to="{ name: 'login' }">Login Here</router-link>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; {{ env.APP_NAME }} {{ env.DATE_YEARS }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <pre>{{ $v }}</pre>
    </div>
</template>
<script>
    import { required, email, minLength } from 'vuelidate/lib/validators'
    import moment from 'moment-timezone'
    import EmailJs from 'emailjs-com'
    export default {
        data() {
            return {
                user: {
                    name: null,
                    email: null,
                    pass: null,
                    jurusan: null,
                    sekolah_id: null,
                    nis: null,
                    jenis_kelamin: null,
                },
                env: {
                    BRAND: 'SIPKL',
                    APP_NAME: 'SI PKL STMIK AKAKOM',
                    DATE_YEARS: new Date().getUTCFullYear(),
                    TIME: { hours: new Date().getHours(), },
                },
                errorTab: [],
                agree: false,
                required: false,
                npsnCollect: [],
                refcount: 0,
                isLoading: false,
                token: 'user_SNdVDAaQM6V5Z2yvud2bY',
            }
        },

        beforeMount() {
            this.getSekolah()
        },

        validations: {
            user: {
                name: { required },
                email: { required, email },
                pass: { required, minLength: minLength(6) },
                jurusan: { required },
                nis: { required }
            },
        },

        methods: {
            getSekolah() {
                axios.get('/api/v2/sekolah/data')
                    .then(res => {
                        var response = res.data?.data
                        response.map(({ id: npsn, nama_sekolah: nama }) => this.npsnCollect.push({ npsn: npsn, nama: nama }))
                    }).catch(e => console.log(e))
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
            submit() {
                this.$v.$touch()
                if (this.$v.$invalid) return
                console.log(this.user)
                this.$emit('registered', this.user)
                this.setLocal()
                this.handleSubmit()
            },

            sendEmailVerif() {
                var params = {
                    subject: 'Konfirmasi Pendaftaran',
                    uniq_id: `#${this.uniq_id()}`,
                    title: 'Welcome!',
                    ucapan: `Selamat ${((this.env.TIME.hours >= 4 ) && (this.env.TIME.hours < 10)) ? 'Pagi' : ((this.env.TIME.hours >= 10 && this.env.TIME.hours < 15) ? 'Siang' : ((this.env.TIME.hours >= 15 && this.env.TIME.hours < 18) ? 'Sore' : (this.env.TIME.hours >= 18 || this.env.TIME.hours < 4) ? 'Malam' : ''))}`,
                    user_name: this.user?.name,
                    content: 'Akun kamu berhasil didaftarkan, namun, akun sedang dalam peninjauan. Segera hubungi pembimbing untuk konfirmasi akun.',
                    quote_ops1: `Email: ${this.user.email}`,
                    quote_ops2: `Password: ${this.user.pass}`,
                    date_y: moment().format('YYYY'),
                    user_email: this.user.email,
                }

                var opts = {
                    service_id: 'service_21xazlk',
                    tamplate_id: 'sipkl_tconfirmations',
                }

                try {
                    var sendEmail = EmailJs.send(opts.service_id, opts.tamplate_id, { ...params }, this.token)
                    console.log('Oke', sendEmail)
                } catch(e) {
                    console.log('Error', e)
                }

                setTimeout(() => {
                    this.removeRegisterStatus()
                }, 2 * 1000) 
            },

            handleSubmit() {
                this.submitUser()
            },

            submitUser() {
                var name = this.user.name.length > 1 ?
                    `${this.user.name.split` `[0]} ${this.user.name.split(/\ +|\-/g).slice(1).map(v => v.charAt(0)).join` `}` : 
                    this.user.name

                axios.post('/api/v2/user/tambah', {
                    name: name,
                    email: this.user.email,
                    password: this.user.pass
                }).then(res => {
                    this.$router.push({ name: 'login', query: { registered: true } })
                    this.sendEmailVerif()                    
                    this.submitSiswa()
                    console.log(res?.data)
                }).catch(e => {
                     this.errorTab.push({ email: 'email sudah pernah digunakan.' })
                     console.log(e)
                })
            },

            submitSiswa() {
                axios.post('/api/v2/siswa/tambah', {
                    nis: this.user.nis,
                    nama_lengkap: this.user.name,
                    jurusan: this.user.jurusan,
                    jenis_kelamin: this.user.jenis_kelamin,
                    sekolah_id: this.user.sekolah_id
                }).then(res => {
                    console.log(res?.data)
                }).catch(e => console.log(e))
            },

            setLocal() {
                localStorage.setItem('registered', true)
            },

            removeRegisterStatus() {
                localStorage.removeItem('registered')
            },

            check(user) {
                return Object.keys(user).length == Object.values(user).filter(v => !!v).length
            },

            uniq_id() {
                return (Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)).toUpperCase()
            },

            sclose() {
                this.user.email = null
                this.errorTab = []
            }
        },

        created() {
            axios.interceptors.request.use((config) => {
                this.$Progress.start()
                this.setLoading(true)
                return config
            }, (error) => {
                this.$Progress.finish()
                this.setLoading(false)
                return Promise.reject(error)
            })

            axios.interceptors.response.use((response) => {
                this.$Progress.start()
                this.setLoading(false)
                return response
            }, (error) => {
                this.$Progress.finish()
                this.setLoading(false)
                return Promise.reject(error)
            })
        },
    }
</script>
