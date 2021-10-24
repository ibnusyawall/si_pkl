<template>
    <div>
      <vue-frappe
            id="test"
            :labels="datacollections.labels"
            title="Statistik Siswa Chart"
            type="axis-mixed"
            :height="300"
            :colors="['purple', '#ffa3ef', 'light-blue']"
            :dataSets="datacollections.datasets">
      </vue-frappe>
      <button v-on:click="refresh()" class="btn btn-primary btn-sm rounded">refresh</button>
    </div>
</template>
<script>
    import { VueFrappe } from 'vue2-frappe'
    export default {
        name: 'stats-chart',
        components: { VueFrappe },
        data() {
            return {
                datacollections: {
                    labels: 'Hadir, Izin, Sakit, Alfa'.split`, `.map(v => v),
                    datasets: [],
                },
                chartType: 'bar, line'.split`, `.map(v => v),
            }
        },
        created() {
            this.getData()
        },
        mounted() {
            console.log('ok')
        },
        methods: {
            getData() {
                axios.get('/api/v1/siswa/all')
                    .then(res => {
                        res.data?.data.map( async ({ nis, nama_lengkap: nama  }) => {
                            try {
                                var kehadiran = await axios.get(`/api/v1/siswa/kehadiran/${nis}`)
                                this.setData(kehadiran.data?.data.kehadiran, nama)
                            } catch(e) { console.log(e) }
                        })
                    }).catch(e => console.log)
            },
            setData(data, nama) {
                var { hadir, sakit, izin, alfa } = data
                this.datacollections.datasets.push({
                    name: `${nama.split` `[0]} ${nama.split` `.slice(1).map(v => v.charAt(0)).join`. `}`,
                    chartType: this.chartType[~~(Math.random() * this.chartType.length)],
                    values: [
                         this.safetyLength(hadir), this.safetyLength(izin), this.safetyLength(sakit), this.safetyLength(alfa)
                    ]
                })
            },
            safetyLength(data) {
                return _.isObject(data) ? Object.keys(data).length : data.length
            },
            refresh() {
                this.datacollections.datasets = []
                this.getData()
            },
        },
    }
</script>
