<template>
    <div>
        <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto" action="">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" name="query" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <!--<button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>-->
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <p class="text-muted p-2 text-center">No notifications found!</p>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="/stisla/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi, {{ user.name }}</div></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Welcome, {{ user.name }}</div>
                            <a href="" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a v-on:click="logout" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                },
                env: {
                    USER: JSON.parse(localStorage.getItem('users')),
                },
            }
        },

        beforeMount() {
            this.user.name = this.env.USER.name
            this.user.email = this.env.USER.email
        },

        methods: {
            logout() {
                this.clearToken()

                this.$router.push({
                    name: 'login',
                    query: { logout: 'true' },
                })
            },

            clearToken() {
                localStorage.removeItem('token')
                localStorage.removeItem('users')
            },
        },

      
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
