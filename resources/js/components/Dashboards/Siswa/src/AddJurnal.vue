<template>
    <div>
        <div class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
              <form @submit.prevent="add">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Data Jurnal</h4>
                  </div>
                  <div class="card-body pb-0">
                    <div class="form-group">
                      <label>Judul</label>
                      <!--<template>-->
                      <!--<input v-if="hasFilled" >-->
                      <input v-if="jurnals.length" type="text" class="form-control" :value="jurnals[0].judul" disabled>  
                      <input v-if="!jurnals.length" type="text" :class="$v.jurnal.judul.$error ? 'form-control is-invalid' : 'form-control'" v-model.trim="$v.jurnal.judul.$model" :disabled="hasFilled" required>
                      <template v-if="$v.jurnal.judul.$error">
                         <div v-if="!$v.jurnal.judul.required" class="invalid-feedback">
                               Judul is required
                         </div>
                      </template>
                    </div>
                    <div class="form-group">
                      <label>Capaian Akhir</label>
                      <input v-if="jurnals.length" type="text" class="form-control" :value="jurnals[0].capaian_akhir" disabled>
                      <input v-if="!jurnals.length" type="text" :class="$v.jurnal.capaian_akhir.$error ? 'form-control is-invalid' : 'form-control'" v-model="$v.jurnal.capaian_akhir.$model" :disabled="hasFilled" required>
                      <template v-if="$v.jurnal.capaian_akhir.$error">
                         <div v-if="!$v.jurnal.capaian_akhir.required" class="invalid-feedback">
                               Capaian Akhir is required
                         </div>
                      </template>
                    </div>
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input v-if="jurnals.length" type="text" class="form-control" :value="jurnals[0].tanggal" disabled>
                      <input v-if="!jurnals.length" type="text" class="form-control" v-model="time" disabled>
                      <!--<div class="invalid-feedback">
                      </div>-->
                    </div>
                  </div>
                  <div class="card-footer pt-0">
                    <a class="btn btn-primary" v-if="hasFilled" :href="$router.resolve({ name: 'view-jurnal-siswa', params: { id: jurnals[0].id } }).href">Detail</a>
                    <button class="btn btn-primary" v-if="!hasFilled" :disabled="isLoading || $v.$invalid">{{ isLoading ? 'wait...' : 'Tambah' }}</button>
                    <a v-on:clic="$router.go(-1)" class="btn btn-primary text-white">Kembali</a>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    import moment from 'moment-timezone'

    export default {
        data() {
            return {
                env: {
                    USER: JSON.parse(localStorage.getItem('users')),
                    TOKEN: localStorage.getItem('token'),
                },
                user: {},
                jurnal: {
                    judul: null,
                    capaian_akhir: null,
                },
                jurnals: [],
                time: '',
                hasFilled: false,
                isLoading: false,
                refcount: 0,
                hasClick: false,
            }
        },
        beforeMount() {
            this.getUser()
        },

        validations: {
            jurnal: {
                judul: { required },
                capaian_akhir: { required }
            }
        },

        mounted() {
            const timer = window.setTimeout(this.getTime, 1000)
            this.$on('hook:destroyed', () => window.clearTimeout(timer))
        },

        methods: {
            getUser() {
                axios.get('/api/v1/getuser')
                    .then(res => {
                        let { user, siswa } = res.data.data
                        this.user.data = user.role == 'siswa' ? { ...siswa } : { ...user }
                        axios.get(`/api/v1/jurnal/nis/${this.user.data?.nis}`)
                            .then(res => {
                                this.setFilterJurnal(res.data.data)
                            }).catch(e => console.log(e))
                    }).catch(e => console.log(e))
            },

            setFilterJurnal(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                this.jurnals = [...arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))]
                this.hasFilled = (this.jurnals.length > 0)
                
                if (!!this.hasFilled && !this.hasClick) this.$toasted.global.error({ message: 'Oops... kamu sudah mengisi jurnal hari ini.' })
                console.log(this.jurnals)
            },

            add() {
                axios.post(`/api/v1/jurnal/tambah`, {
                    judul: this.jurnal.judul,
                    capaian_akhir: this.jurnal.capaian_akhir,
                    tanggal: this.time,
                }).then(res => {
                    let { judul, capaian_akhir } = res.data.data
                    this.$toasted.global.success({ message: 'Data berhasil ditambahkan.' })
                    this.hasClick = true
                    this.getUser()
                    this.jurnal.judul = judul
                    this.jurnal.capaian_akhir = capaian_akhir
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

            getTime(){
                this.time = moment().format('YYYY-MM-DD HH:mm:ss')
                window.setTimeout(this.getTime, 1000)
            },
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
        filters: {
            stringify(json) {
                return JSON.stringify(json, null, '\t')
            },
        },
    }
</script>
