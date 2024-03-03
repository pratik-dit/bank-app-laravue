<template>
  <div class="container auth-screen">
     <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card login-form">
              <div class="card-header" style="text-align:center;">
                 <h2>ABC Bank</h2>
              </div>
              <div class="card-body">
                 <h3 class="card-title text-center">Create a new account</h3>
                 <div class="card-text">
                    <form action="javascript:void(0)" @submit="register" method="post">
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
                          <label for="name" class="mb-1">Name</label>
                          <input
                            type="text"
                            name="name"
                            v-model="user.name"
                            id="name"
                            placeholder="Enter name"
                            class="form-control form-control-md"
                          />
                       </div>
                       <div class="form-group mb-3">
                          <label for="email" class="mb-1">Email Address</label>
                          <input
                            type="text"
                            name="email"
                            v-model="user.email"
                            id="email"
                            placeholder="Enter email address"
                            class="form-control form-control-md"
                          />
                       </div>
                       <div class="form-group mb-3">
                          <label for="password" class="mb-1">Password</label>
                          <input
                            type="password"
                            name="password"
                            v-model="user.password"
                            id="password"
                            placeholder="Enter password"
                            class="form-control form-control-md"
                          />
                       </div>
                       <div class="form-group mb-3">
                          <label for="cpassword" class="mb-1">Confirm Password</label>
                          <input
                            type="password"
                            name="password_confirmation"
                            v-model="user.password_confirmation"
                            id="password_confirmation"
                            placeholder="Enter confirm password"
                            class="form-control form-control-md"
                          />
                       </div>
                       <div class="form-group mb-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked="checked" value="remember-me"> Agree the <a href="javascript:void(0)">terms and policy</a>
                            </label>
                        </div>
                        </div>
                       <div class="row mb-3">
                          <div class="col-md-12">
                             <button
                                type="submit"
                                :disabled="processing"
                                class="btn btn-primary btn-block"
                                >
                                {{ processing ? "Please wait" : "Register" }}
                             </button>
                          </div>
                       </div>
                       <div>
                          Already have an account? 
                          <router-link :to="{name:'login'}">Sign In</router-link>
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
    name:'register',
    data(){
        return {
            user:{
                name:"",
                email:"",
                password:"",
                password_confirmation:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async register(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/register',this.user).then(response=>{
                this.validationErrors = {}
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
        }
    }
}
</script>
