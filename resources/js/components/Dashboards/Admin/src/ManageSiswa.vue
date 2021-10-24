<template>
    <div>
        <b-modal
            id="modal-hapus"
            ref="hapus-data"
            title="Hapus Data Siswa"
            :header-bg-variant="'danger'"
            :header-text-variant="'white'"
            :ok-title="'Hapus'"
            :okVariant="'danger'"
            @ok="handleHapus"
        >
            <p><b>{{ hapus.nama }}</b> akan di hapus, apakah yakin ingin menghapusnya?</p>
        </b-modal>
        <b-modal
            id="modal-hapus-bulk"
            ref="hapus-data-bulk"
            title="Hapus Data Akun"
            :header-bg-variant="'danger'"
            :header-text-variant="'white'"
            :ok-title="'Hapus'"
            :okVariant="'danger'"
            @ok="handleHapusBulk"
        >
            <p><b>{{ hapusBulk.nama }}</b> akan di hapus, apakah yakin ingin menghapusnya?</p>
        </b-modal>
        <div class="row" v-if="sekolah.length && !isLoading" v-for="v in sekolah">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>{{ v.name }}</h4>
                        <button class="btn btn-outline-primary btn-sm">#{{ v.id }}</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Jurusan</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="v.data.length">
                                    <tr v-for="(vs, i) in v.data">
                                        <td>
                                            {{ i += 1 }}
                                        </td>
                                        <td>
                                            {{ vs.nis }}
                                        </td>
                                        <td>
                                            {{ vs.nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ vs.jenis_kelamin | capitalize }}
                                        </td>
                                        <td>
                                            {{ vs.jurusan }}
                                        </td>
                                        <td>
                                        
                                            <button v-if="!!status.length"
                                                :class="status.filter(s => s.id == vs.user_id)[0].status == 'verified' ? 'btn btn-outline-success btn-sm' : 'btn btn-outline-danger btn-sm'"
                                            > {{ status.filter(s => s.id == vs.user_id)[0].status }}
                                            </button>
                                        </td>
                                        <td>
                                            <b-button
                                                v-on:click="removeData(vs.nis, vs.nama_lengkap, vs.user_id)"
                                                :class="'btn btn-danger btn-action mr-1'"
                                             ><i class="fas fa-trash pt-1"></i></b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="!isLoading">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Bulk Account</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="v in bulkAccount">
                                        <td>{{ v.email }}</td>
                                        <td>{{ v.name | capitalize }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-action btn-sm"><i class="fas fa-check pt-1"></i></button>
                                            <b-button
                                                v-on:click="removeDataBulk(v.id, v.name)"
                                                :class="'btn btn-danger btn-action btn-sm'"
                                            ><i class="fas fa-trash pt-1"></i></b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
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
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Data Siswa</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="section-title mt-0">Akun Siswa</div>
                            <div class="form-group">
                                <label>Email</label>
                                <input
                                    type="email"
                                    v-model.trim="user.email"
                                    class="form-control"
                                    placeholder="syawaltech@gmail.com"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input
                                    type="password"
                                    v-model.trim="user.pass"
                                    class="form-control"
                                    placeholder="********"
                                    required
                                >
                            </div>
                            <div class="section-title">Data Siswa</div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input
                                    type="text"
                                    v-model.trim="user.name"
                                    class="form-control"
                                    placeholder="Ibnu"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" v-model="user.jenis_kelamin">
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sekolah</label>
                                <select class="form-control" v-model="user.sekolah_id">
                                    <option v-for="v in npsnCollect" :value="v.npsn">{{ v.nama }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input
                                    id="nis"
                                    type="number"
                                    class="form-control"
                                    v-model="user.nis"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input
                                    type="text"
                                    v-model.trim="user.jurusan"
                                    class="form-control"
                                    placeholder="Rekayasa Perangkat Lunak"
                                >
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <button class="btn btn-primary btn-sm">Tambah</button>
                        </div>
                    </div>
               </form>
            </div>
        </div>
        <!--<div v-if="!!clickEdit" class="row">
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <form @submit.prevent="">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sekolah {{ dataEdit.nama_sekolah }}</h4>
                        </div>
                        <div class="card-body pb-0">
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
        </div>-->
        <pre id="debug">
sekolah: {{ sekolah }}<br>
status: {{ status }}
<!--npsnCollect: {{ npsnCollect }}<br>
data sekolah: {{ sekolah }}-->
        </pre>
    </div>
</template>
<script>
    import { required, minLength } from 'vuelidate/lib/validators'
    import moment from 'moment-timezone'
    import EmailJs from 'emailjs-com'

    export default {
        data() {
            return {
                sekolah: [],
                clickView: false,
                clickClose: false,
                clickEdit: false,
                npsnCollect: [],
                user: {
                    email: null,
                    pass: null,
                    name: null,
                    nis: null,
                    jurusan: null,
                    sekolah_id: null,
                    jenis_kelamin: null,
                },
                hapus: {
                    nis: null,
                    nama: null,
                    user_id: null,
                },
                hapusBulk: {
                    id: null,
                    nama: null,
                },
                env: {
                    TIME: { hours: new Date().getHours(), },
                },
                status: [],
                errorTab: [],
                isLoading: false,
                bulkAccount: [],
                token: 'user_SNdVDAaQM6V5Z2yvud2bY',
            }
        },
        beforeMount() {
            this.getSekolah()
            this.getBulk()
        },
        /*validations: {
            user: {
                name: { required },
                email: { required, email },
                pass: { required, minLength: minLength(6) },
                jurusan: { required },
                nis: { required }
            },
        },*/
        methods: {
            async getSekolah(){
                this.sekolah = []
                this.status = []
                this.npsnCollect = []

                try {
                    let get_npsn = await axios.get('/api/v1/sekolah/data')
                    let res_npsn = get_npsn.data?.data

                    res_npsn.map(({ id: npsn, nama_sekolah: nama }) => {
                        this.npsnCollect.push({
                            npsn: npsn,
                            nama: nama
                        })
                    })

                    this.npsnCollect.map( async ({ npsn, nama }, i) => {
                        try {
                            let get_sekolah = await axios.post('/api/v1/sekolah/siswa', { npsn: npsn })

                            this.sekolah.push({
                                name: nama,
                                id: npsn,
                                data: [...get_sekolah.data?.data],
                                user: []
                            })

                            this.sekolah.map(({ data }) => {
                                try {
                                    data.map( async ({ nis }) => {
                                        try {
                                            let status = await axios.get(`/api/v1/siswa/${nis}`)
                                            
                                            !!status ? this.status.push({...status.data?.data.user }) : console.log(status)
                                        } catch (e) {
                                            this.logger('error', e)
                                        }
                                    })
                                } catch (e) {
                                    this.logger('error', e)
                                }
                            })
                        } catch (e) {
                            this.logger('error', e)
                        }
                    })
                } catch (e) {
                    this.logger('error', e)
                } finally {
                    this.logger('info', 'sukses retrive data.')
                }
            },
            async getBulk() {
                try {
                    let get_bulk = await axios.get('/api/v1/user/all')
                    let res_bulk = get_bulk.data?.data

                    this.bulkAccount = [...res_bulk.filter(v => v.status == 'unverified')]
                } catch (e) {
                    this.logger('error', e)
                }
                /*axios.get('/api/v1/user/all')
                    .then(res => {
                        var response = res.data?.data
                        this.bulkAccount = [...response.filter(v => v.status == 'unverified')]
                    }).catch(e => console.log(e))*/
            },

            submit() {
                console.log(this.user)
                var id = this.randomInt(10, 100)
                this.pushToSekolah(this.user.sekolah_id, id)
                this.pushToStatus(id)
                console.log('id', id)
                this.handleSubmit()
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
                    //this.$router.push({ name: 'login', query: { registered: true } })
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

            pushToSekolah(sekolah_id, id) {
                var i = this.sekolah.findIndex(v => v.id == sekolah_id)
                this.sekolah[i]?.data.push({
                    user_id: id,
                    nis: this.user.nis,
                    nama_lengkap: this.user.name,
                    jenis_kelamin: this.user.jenis_kelamin,
                    sekolah_id: sekolah_id,
                    jurusan: this.user.jurusan,
                })
            },

            pushToStatus(id) {
                this.status.push({
                    id: id,
                    name: this.user.name,
                    email: this.user.email,
                    role: 'siswa',
                    status: 'verified'
                })
            },

            sendEmailVerif() {
                let { protocol, host } = window.location

                var login_page = `${protocol}//${host}/login`
                var params = {
                    subject: 'Konfirmasi Pendaftaran',
                    uniq_id: `#${this.uniq_id()}`,
                    title: 'Welcome!',
                    ucapan: `Selamat ${((this.env.TIME.hours >= 4 ) && (this.env.TIME.hours < 10)) ? 'Pagi' : ((this.env.TIME.hours >= 10 && this.env.TIME.hours < 15) ? 'Siang' : ((this.env.TIME.hours >= 15 && this.env.TIME.hours < 18) ? 'Sore' : (this.env.TIME.hours >= 18 || this.env.TIME.hours < 4) ? 'Malam' : ''))}`,
                    user_name: this.user?.name,
                    content: 'Akun kamu berhasil didaftarkan, silahkan konfirmasi dengan cara <a href="${login_page}">login</a> memggunakan akun berikut dibawah,',
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
            },


            async emptyFormUser() {
                this.user.name = null
                this.user.email = null
                this.user.pass = null
            },
            async emptyFormSiswa() {
                this.user.nis = null
                this.user.name = null
                this.user.jurusan = null
                this.user.jenis_kelamin = null
                this.user.sekolah_id = null
            },
            removeData(nis, nama, user_id) {
                this.$bvModal.show('modal-hapus')
                this.hapus.nis = nis
                this.hapus.nama = nama
                this.hapus.user_id = user_id
            },
            removeDataBulk(id, nama) {
                this.$bvModal.show('modal-hapus-bulk')
                this.hapusBulk.id = id
                this.hapusBulk.nama = nama
            },

            async handleHapus(bvModalEvt) {
                bvModalEvt.preventDefault()
                try {
                    let hapus_siswa = await axios.delete(`/api/v1/siswa/delete/${this.hapus.nis}`)
                    let hapus_users = await axios.delete(`/api/v1/user/delete/${this.hapus.user_id}`)
                } catch (e) {
                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-hapus')
                        this.$toasted.global.error({ message: 'Data gagal dihapus.' })
                    })
                } finally {
                    this.$nextTick(() => {
                        this.refresh()
                        this.$bvModal.hide('modal-hapus')
                        this.$toasted.global.success({ message: 'Data berhasil dihapus.' })
                    })
                }                
            },
            async handleHapusBulk(bvModalEvt) {
                bvModalEvt.preventDefault()
                try {
                    let hapus_user = await axios.delete(`/api/v1/user/delete/${this.hapusBulk.id}`)
                } catch (e) {
                    console.log(e)
                    this.$nextTick(() => {
                        this.refresh()
                        this.$bvModal.hide('modal-hapus-bulk')
                        this.$toasted.global.error({ message: 'Data gagal dihapus.' })
                    })
                } finally {
                    this.$nextTick(() => {
                        this.refresh()
                        this.$bvModal.hide('modal-hapus-bulk')
                        this.$toasted.global.success({ message: 'Data berhasil dihapus.' })
                    })
                }
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
            refresh() {
                this.getSekolah()
                this.getBulk()
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
            uniq_id() {
                return (Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)).toUpperCase()
            },
            randomInt(min, max) {
                return ~~(Math.random() * (max - min) + min)
            },
            logger(type, msg) {
                switch (type) {
                    case 'error':
                        console.log('error', msg)
                        break
                    case 'info':
                        console.log('info', msg)
                        break
                    case 'success':
                        console.log('success', msg)
                        break
                    default:
                        break
                }
            }
        },
        filters: {
            capitalize(text) {
                return !!text ? `${text.charAt(0).toUpperCase()}${text.slice(1)}` : '' 
            },
        },
    }
</script>
