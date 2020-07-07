<template>
  <v-container fill-height class="justify-center flex-column">
    
      <v-form ref="form" action="/login" method="POST">
        <input type="hidden" name="_token" :value="csrf">
        
        <v-card
          class="mx-auto"
          width="100%"
          >
          <v-container>
            <v-card-title class="title font-weight-regular justify-space-between">
              <v-col>
                <v-row>
                  <v-col>
                    Login

                  </v-col>
                  <v-btn color="primary" href="/">Home</v-btn>
                </v-row>
              </v-col>
            </v-card-title>

                <v-row>
                  <v-col>
                    <v-container fill-height>
                        <v-card-text>
                          Already have an account ? Login below or Sign-Up to create an new account               
                          <v-text-field
                            class="mt-4"
                            outlined
                            v-model="email"
                            name="email"
                            label="Email"
                            placeholder="Email"
                            :rules="[rules.required, rules.email]"
                            :error-messages="errormessage"
                          ></v-text-field>
                          <v-text-field
                            outlined 
                            @click:append="show= !show"
                            name="password" 
                            hint="At least 8 characters" 
                            counter 
                            label="Password"
                            placeholder="Password" 
                            v-model="password" 
                            :rules="[rules.required,rules.min]" 
                            :type="show ? 'text' : 'password'" 
                            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                          ></v-text-field>
                          <v-card-actions class="justify-space-between">
                            <v-col>
                              <v-row class="red--text" v-text="this.message"></v-row>
                            </v-col>
                            <v-btn
                              color="warning"
                              href="/register"
                              >
                            Sign-Up
                            </v-btn>
                            <v-btn
                              color="primary"
                              type="button"
                              @click="login"
                              
                              >
                            Login
                            </v-btn>
                          </v-card-actions>
                        </v-card-text>

                    </v-container>
                  </v-col>
                </v-row>
                
              

          </v-container>
        </v-card>
      </v-form>

      <!-- <success-dialog :success="success" :message="'Login Successful'" :location="'/dashboard'" :btn-text="'Proceed'"></success-dialog> -->
    
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      password:'',
      email:'',
      message:'',
      errormessage:'',
      show: false,
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
        email:value=>{
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        },
      },
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      success:false,      

    }),

    
    methods:{
      validate(){
        this.$refs.form.validate()
      },

      login(){
        let flag=false
        if(this.$refs.form.validate()){
          const formData = new FormData()
          formData.append('email',this.email)
          formData.append('password',this.password)


          axios.post('login',formData)
          .then(res=>{
            if(res.data!=''){
              this.message=res.data;
              this.message=res.data;
            }
            else{
              // this.success=true
              window.location='dashboard'
            }
          })
          .catch(err=>{
            this.message=' credentials do not match'
          })

          

        }

      }

    }
  }
</script>