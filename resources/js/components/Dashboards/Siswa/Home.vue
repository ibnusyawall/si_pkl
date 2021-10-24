<template>
    <div>
        <progress-bar></progress-bar>
        <!--<template v-if="isLoading">
            <p>Loading ... {{ refcount }}</p>
        </template>
        <template v-else>-->
        <div v-if="!jurnals.length || !absens.length" class="row">
         <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
                <h4>Pemberitahuan</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                         <span>&times;</span>
                      </button>
                      Kamu belum mengisi {{ (!jurnals.length && !absens.length) ? 'Jurnal atau Absensi' : ((!jurnals.length && !!absens.length) ? 'Jurnal' : (!!jurnals.length && !absens.length) ? 'Absensi' : '') }} hari ini.
                    </div>
                </div>
            </div>
          </div>
         </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success text-white">
                        <i class="far fa-newspaper pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Hadir</h4>
                       </div>
                       <div class="card-body">
                           {{ user.kehadiran.hadir }}
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning text-white">
                        <i class="fas fa-ambulance pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Sakit</h4>
                       </div>
                       <div class="card-body">
                           {{ user.kehadiran.sakit }}
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary text-white">
                        <i class="fas fa-book-reader pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Izin</h4>
                       </div>
                       <div class="card-body">
                           {{ user.kehadiran.izin }}
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger text-white">
                        <i class="fas fa-ban pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Alfa</h4>
                       </div>
                       <div class="card-body">
                           {{ user.kehadiran.alfa }}
                       </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jurnal Kamu</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Judul</th>
                                        <th>Capaian Akhir</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="!user.jurnal">
                                        <p class="text-center">tidak ada data.</p>
                                    </template>
                                    <template v-if="user.jurnal">
                                        <tr v-for="(v, name, index) in user.jurnal">
                                            <td>
                                                {{ v.id }}
                                                <div class="table-links">
                                            in <a href="#">Web Development</a>
                                               <div class="bullet"></div>
                                               <a href="#">View</a>
                                           </div>
                                        </td>
                                        <td>
                                            {{ v.judul }}
                                        </td>
                                       <td>
                                           {{ v.capaian_akhir }}
                                       </td>
                                       <td>
                                           {{ v.tanggal }}
                                       </td>
                                       <td>
                                           <a :href="$router.resolve({ name: 'view-jurnal-siswa', params: { id: v.id }  }).href"  class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="View"><i class="far fa-eye"></i></a>
                                       </td>
                                      </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Teman Kamu di {{ user.data.asal_sekolah }}</h4>
                    </div>
                    <div class="card-body">             
                        <ul class="list-unstyled list-unstyled-border">
                            <li v-for="(v, n, i) in user.teman" class="media">
                                <img class="mr-3 rounded-circle" width="50" src="stisla/img/avatar/avatar-1.png" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right text-primary">{{ v.nis }}</div>
                                    <div class="media-title">{{ v.nama_lengkap }}</div>
                                    <span class="text-small text-muted">{{ v.asal_sekolah }} | {{ v.jurusan }}</span>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center pt-1 pb-1">
                            <a href="#" class="btn btn-primary btn-lg btn-round">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</template>-->
    </div>
</template>

<style>
    .far {
        padding-top: 2px;
        margin-top: 3px;
    }
</style>
<script>
    import ProgressBar from './../../Layouts/ProgressBar'
    export default {
        data(){
            return {
                user: {
                    name: '',
                    role: '',
                    kehadiran: {
                        izin: null,
                        alfa: null,
                        sakit: null,
                        hadir: null,
                    },
                    jurnal: [],
                    data: {},
                    hasFilled: {},
                    teman: [],
                },
                env: {
                    USER: JSON.parse(localStorage.getItem('users')),
                    TOKEN: localStorage.getItem('token'),
                },
                refcount: 0,
                isLoading: false,
                absens: [],
                jurnals: [],
            }
        },

        components: {
            ProgressBar
        },

        beforeMount() {
            axios.defaults.headers.common = {
               'Accept': 'application/json',
               'Authorization': `Bearer ${this.env.TOKEN}`,
            }

            this.user.name = this.env.USER.name
            this.getUser()
        },
        
        methods: {
            getUser() {
                axios.get('/api/v1/getuser')
                    .then(res => {
                        let { user, siswa } = res.data.data
                        this.user.data = user.role == 'siswa' ? { ...siswa } : { ...user }
                        if (user.role == 'siswa') this.setSekolahName(this.user.data?.sekolah_id)
                        axios.get(`/api/v1/siswa/kehadiran/${this.user.data?.nis}`)
                            .then(res => {
                                let { kehadiran, absensi } = res.data.data
                                this.setKehadiran(kehadiran)
                                this.setFilterAbsen(absensi)
                            }).catch(e => console.log(e))
                        axios.get(`/api/v1/jurnal/nis/${this.user.data?.nis}`)
                            .then(res => {
                                console.log(res.data)
                                console.log(`URL: /api/v1/jurnal/nis/${siswa?.nis}`)
                                this.setJurnal(res.data.data)
                                this.setFilterJurnal(res.data.data)
                            }).catch(e => console.log(e))

                        axios.post(`/api/v1/sekolah/siswa`, { npsn: this.user.data?.sekolah_id })
                            .then(res => {
                                this.setTeman(res.data.data)
                            }).catch(e => console.log(e))
                     }).catch(e => console.log(e))
            },

            setSekolahName(id){
                axios.get('/api/v1/sekolah/data')
                    .then(res => {
                        var data = res.data?.data.filter(v => v.id == id)[0]
                        this.user.data.asal_sekolah = data.nama_sekolah
                    }).catch(e => console.log(e))
            },
            setKehadiran(kehadiran) {
                let { hadir, izin, alfa, sakit } = kehadiran
                this.user.kehadiran.hadir = _.isObject(hadir) ? Object.keys(hadir).length : hadir.length
                this.user.kehadiran.sakit = _.isObject(sakit) ? Object.keys(sakit).length : sakit.length
                this.user.kehadiran.alfa = _.isObject(alfa) ? Object.keys(alfa).length : alfa.length
                this.user.kehadiran.izin = _.isObject(izin) ? Object.keys(izin).length : izin.length
            },

            setFilterAbsen(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                this.absens = [...arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))]
                this.user.hasFilled.absen = (this.absens.length > 0)

                console.log(this.absens)
            },

            setFilterJurnal(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                this.jurnals = [...arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))]
                this.user.hasFilled.jurnal = (this.jurnals.length > 0)

                console.log(this.jurnals)
            },

            setJurnal(data) {
                this.user.jurnal = [ ...data ]
            },

            setTeman(data) {
                this.user.teman = [ ...data.filter(v => v.nis != this.user.data?.nis) ]
            },

            toViewJurnal(id) {
                this.$router.push({ name: 'jurnal-siswa', params: { id: id } })
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
        },

        filters: {
            capitalize: function(str) {
                return str.toString().split` `.map(v => v.charAt(0).toUpperCase() + v.slice(1)).join` `
            }
        },

        /*created() {
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
        },*/
    }
</script>
