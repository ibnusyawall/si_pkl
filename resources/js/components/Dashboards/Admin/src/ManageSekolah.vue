<template>
    <div>
        <b-modal
            id="modal-prevent-closing"
            ref="add-data"
            title="Tambah Data Sekolah"
            :header-bg-variant="'primary'"
            :header-text-variant="'white'"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    label="Nomor Pokok Sekolah Nasional (NPSN)"
                    label-for="npsn"
                    invalid-feedback="npsn is required"
                    :state="addState"
                >
                    <b-form-input
                        id="npsn"
                        type="number"
                        v-model="add.id"
                        :state="addState"
                        pattern=".{8,}"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    label="Nama Sekolah"
                    label-for="sekolah"
                    invalid-feedback="nama sekolah is required"
                    :state="addState"
                >
                    <b-form-input
                        id="sekolah"
                        v-model="add.nama_sekolah"
                        :state="addState"
                        required
                    ></b-form-input>
                </b-form-group>
            </form> 
        </b-modal>
        <b-modal
            id="modal-hapus"
            ref="remove-data"
            title="Hapus Data Sekolah"
            :header-bg-variant="'danger'"
            :header-text-variant="'white'"
            :ok-title="'Hapus'"
            :okVariant="'danger'"
            @ok="handleHapus"
        >
            <p>Data sekolah dengan id <b>{{ rId }}</b> akan dihapus bersamaan dengan data siswa yang dicantumkan di sekolah ini, apakah yakin ingin menghapusnya?</p>
        </b-modal> 
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Data Sekolah</h4>
                        <b-button
                            v-on:click="addData"
                            :class="'btn btn-primary btn-sm'"
                        >Tambah Data</b-button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPSN</th>
                                        <th>Nama Sekolah</th>
                                        <th>Jumlah Siswa</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!isLoading" v-for="(v, index) in sekolah">
                                        <td>
                                            {{ index+=1 }}
                                        </td>
                                        <td>
                                            {{ v.npsn }}
                                        </td>
                                        <td>
                                            {{ v.sekolah }}
                                        </td>
                                        <td>
                                            {{ v.count }}
                                        </td>
                                        <td class="text-center">
                                            <a v-on:click="view(v.npsn)" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="View"><i class="far fa-eye"></i></a>
                                            <a v-on:click="edit(v.npsn)" class="btn btn-success btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt pt-1"></i></a>
                                            <b-button
                                                v-on:click="removeData(v.npsn)"
                                                :class="'btn btn-danger btn-action mr-1'"
                                               ><i class="fas fa-trash pt-1"></i></b-button>
                                        </td>
                                    </tr>
                                    <p v-else-if="!!isLoading" class="text-center">Memuat data...</p>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button v-on:click="refresh" class="btn btn-icon icon-left btn-info"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!!clickView" class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 v-if="dataView.length">{{ nama_sekolah }}</h4>
                        <button v-on:click="close()" class="btn btn-danger btn-sm">Close</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jurusan</th>
                                    </tr>
                                </thead>
                                <tbody v-if="dataView.length">
                                    <tr v-for="(v, index) in dataView">
                                        <td>
                                            {{ index+=1 }}
                                        </td>
                                        <td>
                                            {{ v.nis }}
                                        </td>
                                        <td>
                                            {{ v.nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ v.jurusan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!!clickEdit" class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <form @submit.prevent="">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sekolah {{ dataEdit.nama_sekolah }}</h4>
                        </div>
                        <div class="card-body pb-0">
                            <!-- lanjut besok form edit view disini ya, bismillah 29/09/21 -->
                            <div class="form-group">
                                <label>NPSN</label>
                                <input type="number" :class="$v.dataEdit.id.$error ? 'form-control is-invalid' : 'form-control'" v-model.trim="$v.dataEdit.id.$model" :placeholder="dataEdit.id">
                                <div v-if="$v.dataEdit.id.$error && (!$v.dataEdit.id.required || !$v.dataEdit.id.minLength)" class="invalid-feedback">
                                    npsn {{ !$v.dataEdit.id.required ? 'is required' : (!$v.dataEdit.id.minLength ? 'must be at least 8 characters' : '') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Sekolah</label>
                                <input :class="$v.dataEdit.nama_sekolah.$error ? 'form-control is-invalid' : 'form-control'" v-model.trim="$v.dataEdit.nama_sekolah.$model" :placeholder="dataEdit.nama_sekolah">
                                <div v-if="$v.dataEdit.nama_sekolah.$error && !$v.dataEdit.nama_sekolah.required" class="invalid-feedback">
                                    nama sekolah is required
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <button class="btn btn-primary btn-sm" v-on:click="save(dataEdit.npsn)" :disabled="isLoading">{{ isLoading ? 'wait ...' : 'Simpan' }}</button>
                            <button class="btn btn-danger btn-sm" v-on:click="closeEdit()" :disabled="isLoading">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { required, minLength } from 'vuelidate/lib/validators'
    export default {
        data() {
            return {
                sekolah: [],
                refcount: 0,
                isLoading: false,
                clickView: false,
                clickClose: false,
                clickEdit: false,
                dataView: [],
                nama_sekolah: '',
                dE: null,
                dataEdit: {
                    id: null,
                    npsn: null,
                    nama_sekolah: null,
                },
                addState: null,
                add: {
                    id: null,
                    nama_sekolah: null,
                },
                rId: null,
            }
        },
        beforeMount() {
            this.getSekolah()
        },
        validations: {
            dataEdit: {
                id: { required, minLength: minLength(8) },
                nama_sekolah: { required }
            }
        },
        methods: {
            getSekolah(){
                axios.get('/api/v1/sekolah/data')
                    .then(res => {
                        var response = res?.data.data
                        this.dE = response
                        this.LS({ action: 'save', key: 'sekolah', json: response  })
                        this.setDataSekolah(response)
                    }).catch(e => console.log(e))
            },
            setDataSekolah(response) {
                this.sekolah = []
                response.map(({ id, nama_sekolah }) => {
                    axios.post('/api/v1/sekolah/siswa', { npsn: id })
                        .then(res => {
                            var resp = res?.data.data
                            this.sekolah.push({
                                npsn: id,
                                sekolah: nama_sekolah,
                                count: resp.length
                            })
                        }).catch(e => console.log(e))
                })
            },
            view(npsn) {
                this.clickView = true
                axios.post('/api/v1/sekolah/siswa', { npsn: npsn })
                    .then(res => {
                        this.dataView = [...res.data?.data]
                        this.setDataView(npsn)
                    }).catch(e => console.log(e))
            },
            setDataView(npsn) {
                axios.get('/api/v1/sekolah/data')
                    .then(res => {
                        var data = res.data?.data.filter(v => v.id == npsn)[0].nama_sekolah
                        this.nama_sekolah = data
                    }).catch(e => console.log(e))
            },
            close(){
                this.clickView = false
                this.dataView = []
            },
            edit(npsn) {
                var data = this.dE.filter(v => v.id == npsn)[0]
                this.clickEdit = true

                this.dataEdit.id = data.id
                this.dataEdit.npsn = data.id
                this.dataEdit.nama_sekolah = data.nama_sekolah
            },
            save(id) {
                var data = Object.fromEntries(Object.entries(this.dataEdit).filter(([key]) => !key.includes('npsn')))
                axios.post(`/api/v1/sekolah/update/${id}`, { ...data })
                    .then(res => {
                        this.$toasted.global.success({ message: 'Data berhasil di-perbaharui.' })
                        this.setUpdate(res.data?.data)
                    }).catch(e => console.log(e))
            },
            setUpdate(data) {
                this.dataEdit.id = data.id
                this.dataEdit.npsn = data.id
                this.dataEdit.nama_sekolah = data.nama_sekolah

                var i = this.sekolah.findIndex(v => v.npsn == this.dataEdit.id)
                this.sekolah[i].npsn = data.id
                this.sekolah[i].sekolah = data.nama_sekolah 
            },
            closeEdit() {
                this.LS({ action: 'delete', key: 'sekolah' })
                this.dataEdit = {}
                this.clickEdit = false
            },
            addData(){
                this.$refs['add-data'].show()
            },
            removeData(id){
                this.$bvModal.show('modal-hapus')
                this.rId = id
            },
            handleHapus(bvModalEvt) {
                bvModalEvt.preventDefault()
                axios.delete(`/api/v1/sekolah/delete/${this.rId}`)
                    .then(res => {
                        console.log(res)
                        this.$nextTick(() => {
                            this.refresh()
                            this.$bvModal.hide('modal-hapus')
                            this.$toasted.global.success({ message: 'Data berhasil dihapus.' })
                        })
                    }).catch(e => console.log(e))
            },
            checkFormValidity() {
                var valid = this.$refs['form'].checkValidity()
                this.addState = valid
                console.log(valid)
                return valid
            },
            resetModal() {
                this.state = null
                this.add.id = this.add.nama_sekolah = null
            },
            handleOk(bvModalEvt){
                bvModalEvt.preventDefault()
                this.handleSubmit()
            },
            handleSubmit(){
                if (!this.checkFormValidity()) return
                axios.post('/api/v1/sekolah/tambah', {
                    id: this.add.id,
                    nama_sekolah: this.add.nama_sekolah
                }).then(res => {
                    console.log(res.data)
                    this.sekolah.push({
                         npsn: this.add.id,
                         sekolah: this.add.nama_sekolah,
                         count: 0
                    })
                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-prevent-closing')
                        this.$toasted.global.success({ message: 'Data berhasil ditambahkan.' })
                    })
                }).catch(e => console.log(e))
            },
            refresh() {
                this.getSekolah()
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
            LS(v = {}) {
                switch (v?.action){
                    case 'save':
                        var json = JSON.stringify(v?.json)
                        localStorage.setItem(v?.key, json)
                        break
                    case 'get':
                        var json = localStorage.getItem(v?.key) != null ? JSON.parse(localStorage.getItem(v?.key)) : {}
                        return json
                        break
                     case 'delete':
                         localStorage.getItem(v?.key) != null ? localStorage.removeItem(v?.key) : {}
                         break
                     default: 
                        break
                }
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
