<template>
    <div class="container dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm card-box">
                    <div class="card-header">
                        <h2>Welcome {{user.name}}</h2>
                    </div>
                    <div class="card-body">
                      <div>
                        <span class="mb-0 fs-4">You ID: </span>
                        <span class="mb-0 fs-4"><b>{{user.email}}</b></span>
                      </div>
                      <div>
                        <span class="mb-0 fs-4">Your Balance: </span>
                        <span class="mb-0 fs-4"><b>{{user.balance}} INR</b></span>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    name:"dashboard",
    data(){
        return {
            user: {}
        }
    },
    methods: {
      async getUser(page){
          await axios.get('/sanctum/csrf-cookie')
          await axios.get(`/api/me/`).then(({data})=>{
            this.user = data.data
          })
      },
    },
    mounted() {
      this.getUser()
    },
}
</script>