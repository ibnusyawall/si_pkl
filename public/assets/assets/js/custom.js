$(document).ready(function() {
    window.token = !Cookies.get('Authorization') ? 
        Cookies.set('Authorization', '', { expires: 7 }) :
        Cookies.get('Authorization')

    var uri = 'http://localhost:8000/api/v1'
    var options = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${Cookies.get('Authorization')}`,
    }

    function checkAuth() {
        return new Promise(resolve => {
            axios.get(`/api/v1/check`, { headers: {...options} })
                .then(result => {
                    resolve({ status: 200, message: result.data?.message })
                })
                .catch(e => {
                    resolve({ status: e.response?.status, message: e.response?.statusText })
                })
        })
    }

    $('button').on('click', function() {
        let email = $('input[name=email]').val() || 'kosong'
        let password = $('input[name=pass]').val() || 'kosong'

        axios.post(`/api/oauth/login`, { email: email, password: password })
           .then(result => {
               let { token, name } = result.data.data
               Cookies.set('Authorization', token, { expires: 7, path: '/dashboard' })
               Cookies.set('Authorization', token, { expires: 7 })
               window.location = `${uri.replace('/api/v1', '/dashboard/test')}`
//               Cookies.set('Authorization-Name', name)
               console.log(result.data)
           })
           .catch(e => {
               console.log(e.response.data)
           })
        console.log('email: ', email, ' || password: ', password)
    })

    ;(async () => {
       let { status } = await checkAuth()
       let dspath = /dashboard/i.test(window.location.pathname)
       //if (status == 200) window.location = `${uri.replace('/api/v1', '/auth/login')}`

       console.log(status)
       switch (status) {
           case 200:
//               window.location = `${uri.replace('/api/v1', '/dashboard/test')}`
               break
           default:
        //       window.location = `${uri.replace('/api/v1', '/auth/login')}`
               break
       }
   })();
})
