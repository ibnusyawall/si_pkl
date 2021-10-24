<template>
    <div>
        <progress-bar></progress-bar>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-school pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Total Sekolah</h4>
                       </div>
                       <div class="card-body">
                           {{ data.total_sekolah }}
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-graduate pt-1 mt-4"></i>
                    </div>
                    <div class="card-wrap">
                       <div class="card-header">
                           <h4>Total Siswa</h4>
                       </div>
                       <div class="card-body">
                           {{ data.total_siswa }}
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistik Siswa</h4>
                        <div class="card-header-action">
                            <a href="#stat-kehadiran" data-tab="stat-tab" class="btn active">Stat Absensi</a>
                            <a href="#stat-jurnal" data-tab="stat-tab" class="btn">Stat Jurnal</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-chart active" data-tab-group="stat-tab" id="stat-kehadiran">
                               <div class="small">
                                   <stats-chart></stats-chart>
                               </div>
                            </div>
                            <div class="summary-chart" data-tab-group="stat-tab" id="stat-jurnal">
                               <div class="small">
                                   <!--<line-chart :chart-data="datacollection"></line-chart>
                                   <stat-chart></stat-chart>-->
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jurnal Siswa Hari Ini</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Id Sekolah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="!siswa.data.length">
                                        <p class="text-center">tidak ada data.</p>
                                    </template>
                                    <template v-if="siswa.data.length">
                                        <tr v-for="(v, i) in siswa.data">
                                            <td>
                                                {{ v.nis }}
                                            </td>
                                            <td>
                                                {{ v.nama_lengkap }}
                                            </td>
                                            <td>
                                                {{ v.sekolah_id}}
                                            </td>
                                            <td>
                                               <span 
                                                   :class="!!siswa.jurnal.find(x => x.siswa_id == v.nis) ? 'badge badge-success' : 'badge badge-danger'">
                                                   {{ !!siswa.jurnal.find(x => x.siswa_id == v.nis) ?
                                                        'Sudah' :
                                                        'Belum'
                                                   }} Mengisi Jurnal
                                               </span>
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
                        <h4>Absensi Siswa Hari Ini</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Id Sekolah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="!siswa.data.length">
                                        <p class="text-center">tidak ada data.</p>
                                    </template>
                                    <template v-if="siswa.data.length">
                                        <tr v-for="(v, i) in siswa.data">
                                            <td>
                                                {{ v.nis }}
                                            </td>
                                            <td>
                                                {{ v.nama_lengkap }}
                                            </td>
                                            <td>
                                                {{ v.sekolah_id }}
                                            </td>
                                            <td>
                                                <span
                                                    :class="!!siswa.absen.find(x => x.siswa_id == v.nis) ? 'badge badge-success' : 'badge badge-danger'"
                                                >
                                                    {{ !!siswa.absen.find(x => x.siswa_id == v.nis) ?
                                                        capitalize(siswa.absen.find(x => x.siswa_id == v.nis).kehadiran) :
                                                        `Belum Absen`
                                                    }}
                                                </span>
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
        <pre>{{ siswa }}</pre>
    </div>
</template>

<script>
    import moment from 'moment-timezone'
    import ProgressBar from './../../Layouts/ProgressBar'
    import StatsChart from './src/Chart/StatsChart.vue'
    export default {
        data(){
            return {
                data: {
                    total_sekolah: 0,
                    total_siswa: 0
                },
                siswa: {
                    jurnal: [],
                    absen: [],
                    data: [],
                },
                datacollection: null,
                refcount: 0,
                isLoading: false,
                datacollections: {
                    labels: 'Hadir, Izin, Sakit, Alfa'.split`, `.map(v => v),
                    datasets: [],
                },
                chartType: 'bar, line'.split`, `.map(v => v),
            }
        },

        components: { StatsChart, ProgressBar },

        beforeMount() {
            this.getStat()
        },

        mounted() {
        },

        methods: {
            getStat() {
                axios.get('/api/v1/siswa/all')
                    .then(res => {
                        this.siswa.data = [...res.data?.data]
                        this.setFilterJurnal(res.data?.data)
                        this.setFilterAbsens(res.data?.data)
                        this.data.total_siswa = res.data?.data.length
                    }).catch(e => console.log(e))
                axios.get('/api/v1/sekolah/data')
                    .then(res => {
                        this.data.total_sekolah = res.data?.data.length
                    }).catch(e => console.log(e))
            },
            setFilterJurnal(data){
                data.map(({ nis }) => {
                    axios.get(`/api/v1/jurnal/nis/${nis}`)
                        .then(res => {
                            this.setJurnal(res.data?.data)
                        }).catch(e => console.log(e))
                })
            },
            setFilterAbsens(data){
                data.map(({ nis }) => {
                    axios.get(`/api/v1/siswa/kehadiran/${nis}`)
                        .then(res => {
                            var { absensi } = res.data?.data
                            this.setAbsens(absensi)
                        }).catch(e => console.log(e))
                })
            },
            setJurnal(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                let cek = arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))
                if (!!_.isEmpty(cek)) return
                this.siswa.jurnal.push(cek[0])
                console.log('siswa absen', this.siswa.jurnal)
            },
            setAbsens(data) {
                let arr = []
                for (var i = 0; i < data.length; i++) {
                    arr.push(data[i])
                }
                let cek = arr.filter(({ tanggal }) => (tanggal.split` `[0].split`-`[2] >= moment().format('DD') && tanggal.split` `[0].split`-`[1] >= moment().format('MM') && tanggal.split` `[0].split`-`[0] >= moment().format('YYYY')))
                if (!!_.isEmpty(cek)) return
                this.siswa.absen.push(cek[0])
                console.log('siswa absen', this.siswa.jurnal)
            },
            fillData () {
                this.datacollection = {
                    labels: [this.getRandomInt(), this.getRandomInt()],
                    datasets: [
                        {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }, {
                            label: 'Data One',
                            backgroundColor: '#f87979',
                            data: [this.getRandomInt(), this.getRandomInt()]
                        }
                    ]
                }
            },

            getRandomInt () {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
            },

            addDatasets() {
                axios.get('/api/v1/siswa/all')
                    .then(res => {
                        res.data?.data.map( async ({ nis, nama_lengkap: nama  }) => {
                            try {
                                var kehadiran = await axios.get(`/api/v1/siswa/kehadiran/${nis}`)
                                var randomColorHex = this.randomColor()
                                var { hadir, sakit, izin, alfa } = kehadiran.data?.data.kehadiran
                                this.datacollections.datasets.push({
                                    name: `${nama.split` `[0]} ${nama.split` `.slice(1).map(v => v.charAt(0)).join`. `}`,
                                    chartType: this.chartType[~~(Math.random() * this.chartType.length)],
                                    values: [
                                        this.safetyLength(hadir), this.safetyLength(izin), this.safetyLength(sakit), this.safetyLength(alfa)
                                    ]
                                })
                            } catch(e) { console.log(e) }
                        })
                    }).catch(e => console.log)
                    console.log('data collections: ', this.datacollections)
            },

            safetyLength(data) {
                return _.isObject(data) ? Object.keys(data).length : data.length
            },

            randomColor() {
                return '#' + (Math.random().toString(16) + "000000").substring(2,8)
            },

            capitalize(str) {
                return str.split` `.map(v => v.charAt(0).toUpperCase() + v.slice(1)).join` `
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
