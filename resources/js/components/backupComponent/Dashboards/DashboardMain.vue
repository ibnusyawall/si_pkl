<template>
    <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Data Sekolah</h3>
                </div>
                <div class="col text-right">
                  <a v-on:click="showData" href="#!" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Sekolah</th>
                    <th scope="col">NPSN</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                  <tbody v-for="(item, index) in dataSekolah">
                  <tr>
                    <th scope="row">
                      {{ index += 1 }}
                    </th>
                    <td>
                      {{ item.nama_sekolah }}
                    </td>
                    <td>
                      {{ item.npsn }}
                    </td>
                    <td>
                       <button type="button" class="btn btn-outline-primary btn-sm">Detail</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</template>

<script>
    export default {
        data() {
            return {
                dataSekolah: [],
                token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWY3YzEyNTE0ODJhY2U3ZWNlZjlkZmU0MTYzOTA1YWVhNDFkZDQyOTEyODViY2M3MjAwMDI0MzcxY2QyNDQ1MmYzMDM1YWYyN2U3ZGYxOWIiLCJpYXQiOjE2MzA3MjIzMTYuNjgwNDQ1LCJuYmYiOjE2MzA3MjIzMTYuNjgwNDY5LCJleHAiOjE2NjIyNTgzMTYuNjYxODUzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.t8zBavDT9-331wLSCjV1tc_nHw-l_3bR-4udo0JBFc2HgLEVPkwiofQ4QkEpjtnlvPVKGf8pSKQeCh9Eakm8wjdz2BBtTdeYUZZaWwqRdD2fCtd2ovMOIMXJGf_txSgc1qMk4kj4ipT5EB26N44gfYHhSEYDtjA4bo2CQFMoNYMmOsmwa4eApfIVXImjSLu2E6ph17HTbgCK_yCz29be5tJr8rDtZGkQnDDHCUP32ai4xjRM4J0_kon6H8PeRr9NsYmnCZuOSUMZ0v1EOQzqaPy7Dmbc8pM2pLJoej1-iQgWC4VmhzquZyF7BO3WWQWXesEoGKmoxn7RJD34Wo61wO-KbjTbblWhr2BdkDQaovQMv7oHmmToNJeXYTFf3IMpR2jiveAkz8hYUSo8Eh_APfID3VzcrDddn5WN6qaIK_fyvsJSeLADYaDsdjGAEHK7tn7-ITIWujj30XH6o_woNP095yfCwlT_ORusJBkn_MrJDz6Lbo3wGsC-uYgsiimE78VimWrVmW6tcjX4yXw10r-RQeEFtSoaM0cNtAPIzfyIc9TdeTzeXf0Rsn_TW8Y3Ge3-uGAgIWmU9k2phA3H34otJKDb_ZzoBAmUprEDRR6vThJLZ32Uin1dhEhaAf-OgSP_SIHKT8R8U1tQwDq6SvzZoCtCwxLNBnGhwFFrz50',
                isLoggedIn: false
            }
        },
        beforeMount() {
            axios.defaults.headers.common = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
            }
            this.isLoggedIn = !!localStorage.getItem('token')            

            axios.get('/api/v1/sekolah/data')
                .then(res => {
                    res.data.data.map(({ id, nama_sekolah }) => {
                        this.dataSekolah.push({ npsn: id, nama_sekolah: nama_sekolah })
                    })
                    this.dataSekolah.map(({ npsn }, index) => {
                        axios.post('/api/v1/sekolah/siswa', { npsn: npsn })
                            .then(res_ => {
                                this.dataSekolah[index]['jumlah_siswa'] = res_.data.data.length
                            }).catch(e => console.log(e))
                    })
                }).catch(e => console.log(e))
        },
        methods: {
            showData() {
                console.log(this.dataSekolah)
                console.log('is logged in?', this.isLoggedIn)
                console.log('current route is: ', this.$router.name)
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
