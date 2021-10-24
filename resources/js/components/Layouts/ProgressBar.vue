<template>
    <div>
        <template v-if="!!setLoading">
            <p v-if="!!isLoading">Loading ... {{ refcount }} </p>
        </template>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                refcount: 0,
                isLoading: false,
            }
        },
        props: {
            setLoading: {
                type: Boolean,
                default: false
            },
        },
        methods:  {
            _setLoading(isLoading) {
                if (isLoading) {
                    this.refcount++
                    this.isLoading = true
                } else if (this.refcount > 0) {
                    this.refcount--
                    this.isLoading = (this.refcount > 0)
                }
            },
        },
        created() {
            axios.interceptors.request.use((config) => {
                this.$Progress.start()
                if (this.setLoading) {
                    this._setLoading(true)
                }
                return config
            }, (error) => {
                this.$Progress.finish()
                if (this.setLoading) {
                    this._setLoading(false)
                }
                return Promise.reject(error)
            })

            axios.interceptors.response.use((response) => {
                this.$Progress.start()
                if (this.setLoading) {
                    this._setLoading(false)
                }
                return response
            }, (error) => {
                this.$Progress.finish()
                if (this.setLoading) {
                    this._setLoading(false)
                }
                return Promise.reject(error)
            })
        },
    }
</script>
