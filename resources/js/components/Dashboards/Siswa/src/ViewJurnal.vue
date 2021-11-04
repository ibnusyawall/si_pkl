<template>
    <div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <form @submit.prevent="">
                <div class="card">
                  <div class="card-header">
                    <h4>Jurnal #{{ jurnal.id }}</h4>
                  </div>
                  <div class="card-body pb-0">
                    <div class="form-group">
                      <label>Judul</label>
                      <!--<template>-->
                      <input type="text" name="title" class="form-control" v-if="!isEdit" :value="jurnal.judul" :disabled="!isEdit">
                      <input type="text" name="title" :class="$v.jurnal.judul.$error ? 'form-control is-invalid' : 'form-control'"  v-if="isEdit" v-model.trim="$v.jurnal.judul.$model" :placeholder="jurnal.judul" :disabled="!isEdit">
                      <template v-if="$v.jurnal.judul.$error">
                         <div v-if="!$v.jurnal.judul.required" class="invalid-feedback">
                               Judul is required
                         </div>
                      </template>
                    </div>
                    <div class="form-group">
                      <label>Capaian Akhir</label>
                      <input type="text" name="title" class="form-control" v-if="!isEdit" :value="jurnal.capaian_akhir" :disabled="!isEdit">
                      <input type="text" name="title" :class="$v.jurnal.capaian_akhir.$error ? 'form-control is-invalid' : 'form-control'" v-if="isEdit" v-model="$v.jurnal.capaian_akhir.$model" :disabled="!isEdit">
                      <template v-if="$v.jurnal.capaian_akhir.$error">
                         <div v-if="!$v.jurnal.capaian_akhir.required" class="invalid-feedback">
                               Capaian Akhir is required
                         </div>
                      </template>
                    </div>
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="text" name="title" class="form-control" :value="jurnal.tanggal" disabled>
                      <!--<div class="invalid-feedback">
                      </div>-->
                    </div>
                  </div>
                  <div class="card-footer pt-0">
                    <button class="btn btn-primary" v-on:click="setEdit(!isEdit)">{{ isEdit ? 'Simpan' : 'Edit' }}</button>
                    <a v-on:click="$router.back()" class="btn btn-primary text-white">Kembali</a>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    export default {
        data() {
            return {
                jurnal: {},
                isEdit: false,
            }
        },
        beforeMount() {
            axios.get(`/api/v1/jurnal/id/${this.$route.params.id}`)
                .then(res => {
                    this.setJurnal(res.data.data)
                }).catch(e => console.log(e))
        },

        validations: {
            jurnal: {
                judul: { required, },
                capaian_akhir: { required, }
            }
        },

        methods: {
            setJurnal(data) {
                this.jurnal = {...data}
            },

            setEdit(bool) {
                this.isEdit = bool
                this.cancel = !this.isEdit

                if (!this.isEdit) {
                    axios.post(`/api/v1/jurnal/update/${this.$route.params.id}`, {
                        judul: this.jurnal.judul,
                        capaian_akhir: this.jurnal.capaian_akhir,
                    }).then(res => {
                        let { judul, capaian_akhir } = res.data.data
                        this.$toasted.global.success({ message: 'Data berhasil di-perbaharui.' })
                        this.jurnal.judul = judul
                        this.jurnal.capaian_akhir = capaian_akhir
                    }).catch(e => console.log(e))
                }
            },
        },
    }
</script>
