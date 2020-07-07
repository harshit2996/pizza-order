<template>
  <div class="text-center">
    <v-menu v-if="user && user.id!=0"
      v-model="menu"
      :close-on-content-click="false"
      offset-y
      
      >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          text
                    
          v-bind="attrs"
          v-on="on"
          v-text="user.name"
        >
          
        </v-btn>
      </template>

        <v-list>
          <v-list-item>
            <v-list-item-avatar>
              <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title v-text="user.name"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        

        <v-divider></v-divider>

        
          <v-list-item  link>
            <v-list-item-icon>
              <v-icon>
              mdi-account
              </v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title >Profile</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="logout" link>
            <v-list-item-icon>
              <v-icon>
              mdi-logout
              </v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title >Logout</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
    </v-menu>
    <v-col v-else class="shrink">
      <v-row></v-row>
        <v-btn text @click="login">Login</v-btn>
        <v-btn text @click="register">Register</v-btn>

    </v-col>


  </div>
</template>

<script>
  export default {
    data: () => ({
      fav: true,
      menu: false,
      message: false,
      hints: true,
      user:{}
    }),

    mounted(){
      this.user= window.user;
    },

    methods:{
      logout(){
        axios.post('logout')
        .then(res=>{
          window.location='/'
        })
        .catch(err=>{
          console.log(err.response)
        })
      },

      login(){
        window.location="login"
      },
      register(){
        window.location="register"
      }
    }
  }
</script>