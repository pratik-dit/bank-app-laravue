<template>
  <div class="container auth-screen">
     <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card login-form">
              <div class="card-header" style="text-align:center;">
                 <h2>ABC Bank</h2>
              </div>
              <div class="card-body">
                 <h3 class="card-title text-center">Login to your account</h3>
                 <div class="card-text">
                    <form action="javascript:void(0)"  method="post">
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
                          <label for="email" class="mb-1">Email</label>
                          <input
                             type="text"
                             v-model="auth.email"
                             name="email"
                             id="email"
                             class="form-control form-control-md"
                             placeholder="Type Your Email"
                             />
                       </div>
                       <div class="form-group mb-3">
                          <label for="password" class="mb-1">Password</label>
                          <input
                             type="password"
                             v-model="auth.password"
                             name="password"
                             id="password"
                             class="form-control form-control-md"
                             placeholder="Type Your Password"
                             />
                       </div>
                       <div class="row mb-3">
                          <div class="col-md-12">
                             <button
                                type="submit"
                                :disabled="processing"
                                @click="login"
                                class="btn btn-primary btn-block"
                                >
                             {{ processing ? "Please wait" : "Login" }}
                             </button>
                          </div>
                       </div>
                       <div>
                          Don't have an account? 
                          <router-link :to="{name:'register'}">Sign Up</router-link>
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
import { mapActions } from 'vuex'
export default {
    name:"login",
    data(){
        return {
            auth:{
                email:"",
                password:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login',this.auth).then(({data})=>{
                this.signIn()
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
        },
    }
}
</script>