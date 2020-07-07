<template>
  <v-container fluid class="justify-center">

    <v-navigation-drawer
      v-model="drawer"
      temporary
      app
      >

      <v-list subheader nav>
        <v-list-item link @click="componentName='pizzas'">
          
          <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>


          <v-list-item-content>
            <v-list-item-title>View Pizzas</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="componentName='create-pizza'">
          
          <v-list-item-icon><v-icon>mdi-pizza</v-icon></v-list-item-icon>


          <v-list-item-content>
            <v-list-item-title>Add Pizza</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="componentName='all-orders'">
          
          <v-list-item-icon><v-icon>mdi-archive</v-icon></v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>orders</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        <v-list-item link @click="componentName='users-list'">
          
          <v-list-item-icon><v-icon>mdi-account-multiple</v-icon></v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Users</v-list-item-title>
          </v-list-item-content>
          
        </v-list-item>
        
      </v-list>
    </v-navigation-drawer>
    <template>
    <v-container>
      <keep-alive>
        <component v-bind:is="componentName" ></component>
      </keep-alive>

    </v-container>
    </template>
  </v-container>
</template>

<script>
export default {
  props:['maindrawer'],
 

  computed: {
    drawer: {
        get() { return this.maindrawer },
        set(drawer) {this.$emit('update:maindrawer', drawer)}
    }
	},
  
  
  data(){
    return{
      componentName:'all-orders',

    }
  },
  

}
</script>

<style>

</style>