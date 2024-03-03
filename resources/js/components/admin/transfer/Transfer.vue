<template>
  <div class="container dashboard">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm card-box">
          <div class="card-header">
            <h2>Transfer Money</h2>
          </div>
          <div class="card-body d-grid gap-3">
            <div class="card-text">
            <form action="javascript:void(0)" method="post">
              <div
                class="col-12"
                v-if="Object.keys(validationErrors).length > 0"
              >
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <li v-for="(value, key) in validationErrors" :key="key">
                      {{ value[0] }}
                    </li>
                  </ul>
                </div>
              </div>
              <div class="form-group mb-3">
                <label for="email" class="mb-1">Email Address</label>
                <input
                  type="email"
                  id="amount"
                  class="form-control form-control-md"
                  placeholder="Enter email address in which you want to transfer money"
                  v-model="form.email"
                />
              </div>
              <div class="form-group mb-3">
                <label for="amount" class="mb-1">Amount</label>
                <input
                  type="text"
                  id="amount"
                  class="form-control form-control-md"
                  placeholder="Enter amount you want to transfer"
                  v-model="form.amount"
                />
              </div>
              <div class="d-flex justify-content-center">
                <button
                  type="button"
                  class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"
                  :disabled="processing"
                  @click="save"
                >
                  {{ processing ? "Please wait" : "Save" }}
                </button>
              </div>
            </form>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import router from '@/router'
export default {
  name: "Add",
  data() {
    return {
      form: {
        amount: '',
        email: '',
      },
      processing:false,
      validationErrors:{},
    }
  },
  methods: {
    async save() {
      if(confirm("Are you sure to transfer money to someones account?")){
        this.processing = true
        await axios.post('/api/account/transfer', this.form).then(({data})=>{
          if(data.status===401){
            this.validationErrors = {error:[data.message]}
          }else{
            router.push({name:'dashboard'})
          }
        }).catch(({response})=>{
          if(response.status===422){
                this.validationErrors = response.data.errors
            }else{
                this.validationErrors = {}
                alert(response.data.message)
            }
        }).finally(()=>{
            this.processing = false
        })
      }
    }
  }
}
</script>
<style scoped>
.mx-t3 {
  margin-top: -3rem;
}
</style>
