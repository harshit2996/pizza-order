<template>
  <v-container fill-height fluid class="justify-center">
    <v-navigation-drawer
      v-model="drawer"
      app
      temporary
      >

      <v-list subheader nav>
        <v-list-item link @click="componentName='pizzas'">
          
          <v-list-item-icon><v-icon>mdi-view-dashboard</v-icon></v-list-item-icon>


          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="componentName='profile'">
          
          <v-list-item-icon><v-icon>mdi-account</v-icon></v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="componentName='my-orders'">
          
          <v-list-item-icon><v-icon>mdi-archive</v-icon></v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>My Orders</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="logout">
          
          <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        
      </v-list>
    </v-navigation-drawer>
    <keep-alive>
      <component v-bind:is="componentName" :rdrawer.sync="rdrawer" :nitems.sync="nitems"></component>
    </keep-alive>
  </v-container>
</template>

<script>
export default {
  props:['maindrawer','rightdrawer','numitems'],
 

  computed: {
    drawer: {
        get() { return this.maindrawer },
        set(drawer) {this.$emit('update:maindrawer', drawer)}
    },

    rdrawer: {
        get() { return this.rightdrawer },
        set(rdrawer) {this.$emit('update:rightdrawer', rdrawer)}
    },
    nitems: {
        get() { return this.numitems },
        set(nitems) {this.$emit('update:numitems', nitems)}
    }
	},
  
  
  data(){
    return{
      componentName:'pizzas',

    }
  },

  methods:{
    logout(){
      axios.post('logout')
      .then(res=>{
        window.location='/'
      })
      .catch(err=>{
        console(err.response)
      })
    }
  }
  

}
</script>

<style>

</style>