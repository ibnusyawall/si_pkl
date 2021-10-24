<template>
<div>
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>Or sign in with credentials</small>
                    </div>
                    <div v-if="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ error }}
                        <button type="button" v-on:click="closeToast" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--<div v-if="error">
                        <div class="alert bg-danger text-white m-4">
                            {{ error }}
                        </div>
                    </div>-->
                    <form @submit.prevent="submit">
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email" type="email" v-model="user.email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="Password" type="password" v-model="user.pass">
                            </div>
                        </div>
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                            <label class="custom-control-label" for=" customCheckLogin">
                                <span class="text-muted">Remember me</span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--<div class="row mt-3">
                <div class="col-6">
                    <a href="#" class="text-light"><small>Forgot password?</small></a>
                </div>
                <div class="col-6 text-right">
                    <a href="#" class="text-light"><small>Create new account</small></a>
                </div>
            </div>-->
        </div>
    </div>
  </div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                user: {
                    email: '',
                    pass: '',
                },
                error: '',
            }
        },
        methods: {
            submit() {
                axios.post('/api/oauth/login', { email: this.user.email, password: this.user.pass })
                    .then(res => {
                        let { name, token } = res.data.data
                        localStorage.setItem('username', name)
                        localStorage.setItem('token', token)
                        this.$emit('setData')
                        this.$router.push({ name: 'dashboard-home' })
                    }).catch(e => {
                        this.error = e.response.data.data.error
console.log(e)
                        console.log(e.response.data.data.error)
                    })
            },
            closeToast() {
                setTimeout(() => {
                    this.user.email = ''
                    this.user.pass  = ''
                }, 1000)
                console.log(this.error.split``)
                this.error = ''
            },
        }
    }
</script>
