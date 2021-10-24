<template>
    <div>
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="">{{ env.BRAND }}</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="index.html">{{ env.BRAND }}</a>
            </div>
            <ul class="sidebar-menu">
                <template v-if="env.IS_SISWA">
                    <li class="menu-header">Dashboard</li>
                    <li class="active">
                        <a class="nav-link" href="">
                            <i class="fa fa-square"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="blank.html">
                            <i class="far fa-square"></i>
                            <span>Jurnal</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="blank.html">
                            <i class="far fa-square"></i>
                            <span>Absensi</span>
                        </a>
                    </li>            
                </template>
                <template v-else>
                    <li class="menu-header">Dashboard</li>
                    <li class="active">
                        <a class="nav-link" href="">
                        <i class="fa fa-columns"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="menu-header">Kelola</li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Sekolah</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="forms-advanced-form.html">Lihat Data</a></li>
                            <li><a class="nav-link" href="forms-editor.html">Tambah Data</a></li>
                        </ul>
                    </li>
                </template>
            </ul>
        </aside>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                env: {
                    TOKEN: localStorage.getItem('token'),
                    IS_SISWA: null,
                    BRAND: 'SI PKL',
                    ucapan: '',
                },
                user: {
                    role: '',
                    data: {},
                },
            }
        },

        beforeMount() {
            axios.defaults.headers.common = {
               'Accept': 'application/json',
               'Authorization': `Bearer ${this.env.TOKEN}`,
            }
            this.getUser()
        },

        methods: {
            getUser() {
                axios.get('/api/v1/getuser')
                    .then(res => {
                        let { user, siswa } = res.data.data
                        this.setRole(user.role)
                        this.user.data = this.user.role == 'siswa' ? { ...siswa } : { ...user }
                     }).catch(e => console.log(e))
            },

            setRole(role) {
                this.env.IS_SISWA = (role == 'siswa') ? true : false
                this.user.role = role
            },            
        },
    }
</script>
