/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios')

import VueRouter from 'vue-router'
import Toast from 'vue-toasted'
import Vuelidate from 'vuelidate'
import VueProgress from 'vue-progressbar'
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm'

import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'material-icons/iconfont/material-icons.css'

import Chart from 'vue2-frappe'

Vue.use(VueRouter)
Vue.use(Toast, {
    iconPack : 'material',
    theme: 'bubble',
    fullWidth: false,
})

Vue.use(VueProgress, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
}

Vue.use(Vuelidate)
Vue.use(BootstrapVue)

Vue.config.productionTip = Vue.config.devtools = false

var defaultDuration = 2000 // 2 second, 

Vue.toasted.register('success', m => {
    if (!m.message) return 'Success...'
    return m?.message
}, {
    type: 'success',
    icon: { name: 'check_circle_outline' },
    duration: defaultDuration,
    fitToScreen: true,
})

Vue.toasted.register('info', m => {
    if (!m.message) return 'Info!'
    return m?.message
}, {
    type: 'info',
    icon: { name: 'highlight_off' },
    duration: defaultDuration,
    fitToScreen: true,
})

Vue.toasted.register('error', m => {
    if (!m.message) return 'Oops...'
    return m?.message
}, {
    type: 'error',
    icon: { name: 'error_outline' },
    duration: defaultDuration,
    fitToScreen: true,
})

import App from './components/App.vue'
import Toc from './components/Toc'

import Login from './components/Auth/Login'
import Register from './components/Auth/Register'

import MainApp from './components/Dashboards/MainApp.vue'
import ViewJurnal from './components/Dashboards/Siswa/ViewJurnal'
import AddJurnal from './components/Dashboards/Siswa/AddJurnal'
import AddAbsen from './components/Dashboards/Siswa/AddAbsen'

import ManageSekolah from './components/Dashboards/Admin/ManageSekolah'
import ManageSiswa from './components/Dashboards/Admin/ManageSiswa'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: { guest: true },
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: { guest: true },
        },
        {
            path: '/term-of-conditions',
            name: 'toc',
            component: Toc,
            meta: { guest: true },
        },
        {
            path: '/dashboard',
            name: 'dashboard-home',
            component: MainApp,
            props: true,
            meta: { requiresAuth: true },
        },
        {
            path: '/dashboard/j/:id',
            name: 'view-jurnal-siswa',
            component: ViewJurnal,
            props: true,
            meta: { requiresAuth: true },
        },
        {
            path: '/dashboard/tambah-jurnal',
            name: 'jurnal-tambah',
            component: AddJurnal,
            props: true,
            meta: { requiresAuth: true, siswaOnly: true  },
        },
        {
            path: '/dashboard/absensi',
            name: 'absen-tambah',
            component: AddAbsen,
            props: true,
            meta: { requiresAuth: true, siswaOnly: true },
        },

        {
            path: '/dashboard/manage/sekolah',
            name: 'manage-sekolah',
            component: ManageSekolah,
            props: true,
            meta: { requiresAuth: true  },
        },
        {
            path: '/dashboard/manage/siswa',
            name: 'manage-siswa',
            component: ManageSiswa,
            props: true,
            meta: { requiresAuth: true },
        },
    ]
})

router.beforeEach(async (to, from, next) => {
    let token = localStorage.getItem('token') == null
    let user = JSON.parse(localStorage.getItem('users'))

    try {
        let validToken = await checkLoggedIn()

        if (to.matched.some(record => record.meta.requiresAuth)) {
            if (token || !validToken) {
                next({
                    name: 'login',
                    query: { redirect: to.fullPath },
                })
            } else if ((!token && to.matched.some(record => record.meta.siswaOnly)) && user.role == 'pembimbing') {
                next({
                    name: 'dashboard-home',
                })
            } else {
                next()
            }
        } else {
            next()
        }
    } catch (e) {
        console.log(e)
    }
})

const app = new Vue({
    el: '#app',
    data() {
        return {
            author: 'ibnusyawal',
        }
    },
    components: {
         App,
    },
    router,
});

function checkLoggedIn() {
    return new Promise(resolve => {
        axios.get(`${location.origin}/api/v1/check`)
            .then(res => resolve(true))
            .catch(e => resolve(false))
    })
}
