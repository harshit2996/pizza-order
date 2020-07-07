<template>
  <v-container fill-height class="justify-center">
    <v-form ref="form" action="register" method="POST" style="width:80%">
      <input type="hidden" name="_token" :value="csrf">

      <v-card
        class="mx-auto"
        width="100%"
        >
        <v-container>
          <v-card-title class="title font-weight-regular justify-space-between">
            <span>{{ currentTitle }}</span>
          </v-card-title>
          
          

          <v-window v-model="step">
            
            <v-window-item :value="1">
              <v-card-text>
                <v-text-field
                  class="mt-4"
                  outlined
                  v-model="name"
                  name="name"
                  label="Name"
                  placeholder="Name"
                  :rules="[rules.required]"
                ></v-text-field>
                
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
                <span class="caption grey--text text--darken-1">
                  This is the email you will use to login to your Vuetify account
                </span>
              </v-card-text>          
            </v-window-item>

            <v-window-item :value="2">
              <v-card-text>
                <v-text-field 
                  @click:append="show= !show"
                  name="password" 
                  hint="At least 8 characters" 
                  counter 
                  outlined
                  label="Password" 
                  v-model="password" 
                  :rules="[rules.required,rules.min]" 
                  :type="show ? 'text' : 'password'" 
                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                ></v-text-field>
                <v-text-field label="Confirm Password" outlined v-model="confirmPassword" :rules="([rules.required]).concat(passwordConfirmationRule)" type="password" required></v-text-field>

                <v-container>
                  <v-col>
                    <v-row v-text="this.message"></v-row>
                  </v-col>
                </v-container>
              </v-card-text>
            </v-window-item>

            <v-window-item :value="3">
              <div class="pa-4 text-center">
                <v-img
                  class="mb-4"
                  contain
                  height="128"
                  src="img/logo.png"
                ></v-img>
                <h3 class="title font-weight-light mb-2">Your Account has been setup please login and Continue</h3>
                <span class="caption grey--text">Thanks for signing up!</span>
              </div>
            </v-window-item>
          </v-window>

        </v-container>
        <v-divider></v-divider>

        <v-card-actions>
          <v-btn
            :disabled="step ===1 || step===3"
            text
            @click="step--"
          >
            Back
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            v-if="step===1"
            color="primary"
            depressed
            type="button"
            @click="validate"
          >
            Next
          </v-btn>
          <v-btn
            v-if="step===2"
            color="primary"
            @click="postdata"                       
            
                        
          >
            Submit
          </v-btn>
          <v-btn
            v-if="step===3"
            color="primary"
            depressed
            href="login"
            >
            Login

          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-form>
    
  </v-container>
</template>

<script>
  export default {
    data(){
      return{
        step: 1,
        name:'',
        email:'',
        message:'',
        errormessage:'',
        password:'',
        confirmPassword:'',
        show: false,
        rules: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 8 || 'Min 8 characters',
          email:value=>{
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          },
          emailCheck:value=>{
            if(value){
              const formData = new FormData()
              formData.append('email',this.email)
              axios.get('/register/check')
              .then(res=>{
                res.data.forEach(user => {
                  
                  // console.log(user.email)
                  if(user.email==value){
                    this.email='User Already taken'
                    return this.email ||'User Already registered'
                  }
                })
              })
              .catch(err=>{
                
              })

            }
            return true

          }
        },
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')      
      }
    },

    computed: {
      currentTitle () {
        switch (this.step) {
          
          case 1: return 'Personal Details'
          case 2: return 'Create a password'
          default: return 'Account created'
        }
      },

      passwordConfirmationRule() {
      return () =>
        this.password === this.confirmPassword || "Password must match";
      },

      // checkemail(){
      //   if(this.email){
      //     return ()=>{
      //       this.check()===true || "email already taken"
      //     }

      //   }
      // }

    },

    watch:{
      email:function () {
        // return()=>{
          this.check()
        // }
      }
    },

      

    methods:{
      validate(){
        this.$refs.form.validate()
        if(this.$refs.form.validate())
          this.step++
      },

      postdata(){
        if(this.$refs.form.validate()){
          const formData = new FormData();
          formData.append('name',this.name)
          formData.append('email',this.email)
          formData.append('password',this.password)

          axios.post('register',formData)
          .then(res=>{
            console.log(res)
            this.step++
          })
          .catch(err=>{
            this.message='Please Enter unique Email and Password'
            console.log(err.response)
          })
        }
      },

      check(){
        // console.log('called')
        this.errormessage=''
        axios.get('/register/check')
        .then(res=>{
          res.data.forEach(user => {
            if(user.email==this.email){
              this.errormessage="email already taken"
              return false
            }
            
          });
        })
        .catch(err=>{
          console.log(err.response.data.message)
        })
        return true
      }

    }
  }
</script>