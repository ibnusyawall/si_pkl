var axios = require('axios')
var needle = require('needle')

var location = {}
location.origin = 'http://localhost:8000'

var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTdhMjY0MDc0OTAzOGZhM2FiY2Q5NWQ2NGNkN2MyYmJmMmQ4ZDgxNWQ0Mjg5YjJhNTdlNzY3ZTk5MGM3ZGI3ZTM0MjhkNzcyNTMyNjA1NjciLCJpYXQiOjE2MzEzNTEyMTAuNzY1MDM4LCJuYmYiOjE2MzEzNTEyMTAuNzY1MDY2LCJleHAiOjE2NjI4ODcyMTAuNzI3MjQ1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.oRPdtx7osOHJjrDCCQIRzrMETzaBeren_ZhAfanBYBBKabTZpLRwFzZc3ELe5zWLlbcuynKpZ9co-0Hm5dV4lzTurcIc9h3KuE5rBb7ts1mdwimonuI3MCvGDuHDy18oxC3amNbnYzXv6aD2czrR-J-bF811pbu82wrxzRpKAPa53G50St-Uy8ACy-IZt-XqfuIapEiyqhh5n6yZ2-_-Xs_8MFtPb96Ec5QABat_ThtpUJIrPaSWi4FUf9mlXou2NbZX0YaefqA0CQXqnIhQhRte7C9_ttOEswIz6NVP7uR942Z5r2yGK8X4U5SAleYkn5DcBDQK9Lz-m28LxVbOwUvWFFTxi0t0RStpcRIdPD7dliqA3fIebCO2cbh6DHhXdAiFiGF7YGk4VuGj1vL1blDAM58KhLuHg6554tSsCxhFySuJdXW0PKt7yv1xtwW4_1KpIU0qNQ2JPZv2ETgerBmH11E9QV_vZP2_HuKHdNQQfua7KFP-U6uvirxErUua8Y_eo5U31T_NRdxTaYMAmca3sdHPa1aqrPXcgAb3Fti32VuKe37A-lSxABQqmsHd8JGDXFo4buZq_gs9EwrO8BmZ94zfMbdg8mdgKuuSO9rWFbnlE_7xyQD1KZ83V7rV9jG3LYfa9L_YvhFSXvdjzG8JjK7QmbSbshKDmTeh6RQ'

needle.defaults().headers = {
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`,
}

/*function checkLoggedIn() {
    return new Promise(async resolve => {
        needle.get(`${location.origin}/api/v1/check`, (e, resp, body) => {
            resolve(e ? false : true)
        })
    })
}
*/

async function checkLoggedIn() {
    let { data } = await axios.get(`${location.origin}/api/v1/check`) || false
    return data
}

/*;(async () => {
    try {
        let isLoggedIn = await checkLoggedIn()
        console.log(isLoggedIn)
    } catch(e) {
        //
    }
})()
*/

//var st = checkLoggedIn()
//console.log(st)

checkLoggedIn().then(v => {
    console.log(v)
}).catch(e => console.log(e))
/*
class checkLogin {
    constructor() {
        this.baseUrl = location.origin
        this.status;
    }

    check() {
        return new Promise(resolve => {
            axios.get(`${this.baseUrl}/api/v1/check`)
                .then(res => {
                    resolve(res.data)
                }).catch(e => {
                    resolve(false)
                })
        })
    }

    async sts() {
        this.check().then(v => {
            this.status = v
        }).catch(e => {
            this.status = e
        })
        return this.status
        this.status = await this.check()
        return this.status
    }
}

cek = new checkLogin().sts()

console.log(cek)
*/
