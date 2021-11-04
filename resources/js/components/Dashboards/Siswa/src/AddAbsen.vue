<template>
    <div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <form @submit.prevent="add">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Data Absensi</h4>
                  </div>
                  <div class="card-body pb-0">
                    <div class="form-group">
                      <label>Kehadiran</label>
                      <select class="form-control selectric" v-model="kehadiran" :disabled="hasFilled">
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alfa">Alfa</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input v-if="absens.length" type="text" class="form-control" :value="absens[0].tanggal" disabled>
                      <input v-if="!absens.length" type="text" class="form-control" v-model="time" disabled>
                      <!--<div class="invalid-feedback">
                      </div>-->
                    </div>
                  </div>
                  <div class="card-footer pt-0">
                    <button class="btn btn-primary" v-if="!hasFilled" :disabled="isLoading">{{ isLoading ? 'wait...' : 'Kirim' }}</button>
                    <a v-on:click="$router.go(-1)" class="btn btn-primary text-white">Kembali</a>
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
                kehadiran: '',
                absens: [],
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
                        axios.get(`/api/v1/siswa/kehadiran/${this.user.data?.nis}`)
                            .then(res => {
                                let { absensi } = res.data.data 
                                this.setFilterAbsen(absensi)
                            }).catch(e => console.log(e))
                    }).catch(e => console.log(e))
            },

            setFilterAbsen(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                this.absens = [...arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))]
                this.hasFilled = (this.absens.length > 0)
                this.kehadiran = this.absens.length > 0 ? this.absens[0].kehadiran : this.kehadiran                
                if (!!this.hasFilled && !this.hasClick) this.$toasted.global.error({ message: 'Oops... kamu sudah mengisi absensi hari ini.' })
                console.log(this.absens)
            },

            add() {
                axios.post(`/api/v1/absen/tambah`, {
                    siswa_id: this.user.data?.nis,
                    kehadiran: this.kehadiran,
                    tanggal: this.time,
                }).then(res => {
                    let { kehadiran } = res.data.data
                    this.$toasted.global.success({ message: 'Data berhasil ditambahkan.' })
                    this.hasClick = true
                    this.getUser()
                    this.kehadiran = kehadiran
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
    }
</script>
