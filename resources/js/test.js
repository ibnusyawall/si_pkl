var axios = require('axios')
var _ = require('lodash')

var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZTIyMDgwNDMzMjJiZmJkMTZkMDU5ZTU5NDY3ZmI1MDQyM2FhNjlhYTNjN2Y2NmMzYmY2MTk2ZGI4ZGVhYzdiYjBjMDAxNjc0ODkxOGQyZmUiLCJpYXQiOjE2MzIxMTgxNTEuMTA4NjcyLCJuYmYiOjE2MzIxMTgxNTEuMTA4NzE3LCJleHAiOjE2NjM2NTQxNTEuMDAxNDIsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.tdMOidFicXE90o8rTtLuxyHiaH-cDNcc-Jld6XVOFge2wiM2AolWQxwWf4Jj-LvbSCCfbYgPUqhysnAiQXkPyU0oRkeXJipBL1t7XG8H7B-W5ShI2OJbaBOUzZNOq9jp9SSUm_MG33mK7oZx34QSB7kGIxv9n9nrTG5c1fF9LMDSAjceF1Vvk6QAQstz1xNlgkmf7zCK-ha894A569XFlVlWh6P5LgUlFX8z-UFB8kiTQnV8AJRSKy9RrTxiG04faP_HJ_UaSdDzwnUXotrl47Rm_bZ_I3u42ZNh4Lr-tO5mPML-ArSZSD2udD1vYJGHM_XmB0w473BoQIyX6U9IitjQ_vNw-qawUj6LmFBe-t478nOpkBcGRSLNjboyNpBcLTLH5zZ2yBtq1XJs0Ayd61vxz1uEraXZ4EIUNe9ZIUSoKMOIYVmTAotZjVKx0siUC4LIjIdMRfmb-fBbRlKRh0lAFogkaGm-qYgi_Zh9_jIVeUUE0W63dKnA4Xp4zxjXWp-vlI9_zNp5nlXhd1z3MoQrFzjV3z3YPj_EngwHvlM8iyvBDzntTLU8jFxBLRJRj--9V9SuMaFV5ZDD1WIdWT4zj-BGJr_T2INwQEd9zdwrY_hyU4HTbZOHIxQ6Jo4Gl1tx1nr9lGMGRqesQXknAodmMgV5DHx2Lal6p96FC1U'

var datasets = []

axios.defaults.headers.common = {
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`,
}

var url = 'http://localhost:2000'

axios.get(`${url}/api/v1/siswa/all`)
    .then(res => {
        res.data?.data.map( async ({ nis, nama_lengkap: nama  }) => {
            try {
                var kehadiran = await axios.get(`${url}/api/v1/siswa/kehadiran/${nis}`)
                
                let { hadir, sakit, izin, alfa } = kehadiran.data.data.kehadiran
                /*kehadiran.data?.data.kehadiran.map(({ hadir, sakit, izin, alfa }) => {
                    this.datasets.push({
                        label: nama,
                    })
                })*/
                datasets.push({ label: nama })
                console.log(nama, ' izin: :', safetyLength(izin), '\n\n')
            } catch(e) {  console.log(e) }
        })
//        console.log(res)
    }).catch(e => console.log)

console.log(datasets)

function safetyLength(data) {
    return _.isObject(data) ? Object.keys(data).length : data.length
}
