<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            {{ env.BRAND }}
                        </div>
                        <!--<div v-if="error.status" class="alert alert-danger">
                            {{ iziToast('') }}
                        </div>-->

                        <div class="card card-primary">
                            <div class="card-header"><h4>Login</h4></div>

                            <div class="card-body">
                                <div v-if="isregister" class="alert alert-info alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert" v-on:click="rclose">
                                            <span>×</span>
                                        </button>
                                        Registrasi berhasil, silahkan cek email kamu.
                                    </div>
                                </div>
                                <div v-if="!!nonverified" class="alert alert-info alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert" v-on:click="sclose">
                                            <span>×</span>
                                        </button>
                                        Akun kamu belum diverifikasi, silahkan hubungi pembimbing untuk meminta diverifikasi.
                                    </div>
                                </div>
                                <form @submit.prevent="submit">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input v-model.trim="$v.user.email.$model" aria-describedby="emailHelpBlock" id="email" type="email" :class="$v.user.email.$error ? 'form-control is-invalid' : 'form-control'" tabindex="1" placeholder="email address" autofocus :disabled="isLoading">
                                        <template v-if="$v.user.email.$error">
                                            <div v-if="!$v.user.email.required" class="invalid-feedback">
                                                Email is required
                                            </div>
                                            <div v-if="!$v.user.email.email" class="invalid-feedback">
                                                Email is invalid
                                            </div>
                                        </template>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                               <a href="" class="text-small">
                                                   Forgot Password?
                                               </a>
                                            </div>
                                       </div>
                                       <input v-model.trim="$v.user.pass.$model" aria-describedby="passwordHelpBlock" id="password" type="password" :class="$v.user.pass.$error ? 'form-control is-invalid' : 'form-control'" tabindex="2" placeholder="Your account password" :disabled="isLoading">
                                       <template v-if="$v.user.pass.$error">
                                           <div v-if="!$v.user.pass.required" class="invalid-feedback">
                                               Password is required
                                           </div>
                                           <div v-if="!$v.user.pass.minLength" class="invalid-feedback">
                                               Password must be at least 4 characters
                                           </div>
                                       </template>
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" :disabled="isLoading || $v.$invalid">
                                            {{ isLoading ? `wait...` : 'Login' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-5 text-muted text-center">
                            Don't have an account? <router-link :to="{ name: `register` }">Create One</router-link>
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
                            if (!!this.$route.query.redirect)
                                window.location = `${window.location.origin}${this.$route.query.redirect}`
                            else
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
