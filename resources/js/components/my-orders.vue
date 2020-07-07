<template>
  <v-container fill-height class="justify-center">
    <v-data-table
      :headers="headers"
      :items="orders"
      
      class="elevation-1"
      >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>Orders</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
      
      <template v-slot:item.order="{ item }">
        <v-container style="height:fit-content">
            <v-card
              v-for="(pizza,i) in item.order.items"
              :key="i" 
              flat
              outlined 
              width="300" 
              class="pa-1 ma-2">
              <v-container class="fill-height">
                  <v-row>
                    <v-img max-width="75" aspect-ratio="1" contain :src="'/img/'+pizza.image"></v-img>
                    <v-divider vertical class="mx-2"></v-divider>
                    <v-col class="grow flex-column pa-1">
                      <v-card-text v-text="pizza.pizza_name" class="py-1"></v-card-text>
                      <v-card-subtitle v-text="pizza.pizza_desc" class="py-1"></v-card-subtitle>
                    </v-col>
                  </v-row>
                  <v-row class="d-flex align-end pa-0">
                      <v-row justify="center" v-text="'Price: € '+ (pizza.price)"></v-row>
                      <v-row justify="center" v-text="'Qty: '+pizza.quantity"></v-row>
                  </v-row>
              </v-container>
            </v-card>
        </v-container>
        
      </template>


    </v-data-table>

  </v-container>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      headers: [
        {
          text: 'Order_Id',
          align: 'start',
          sortable: false,
          value: 'order_id',
        },
        { text: 'Name', value: 'Name' },
        { text: 'Address', value: 'address' },
        { text: 'Order', value: 'order' },
        { text: 'Amount', value: 'bill' },
        { text: 'Phone', value: 'phone' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      orders: [],
      editedIndex: -1,
      editedItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        
        axios.get('/userorder')
        .then(res=>{
          let arr=Array()
          if(res.data){
            for (const i in res.data) {
              if (res.data.hasOwnProperty(i)) {
                let element = res.data[i]
                element.order=JSON.parse(element.order)
                // console.log(element.order)
                arr.push(element)
                
              }
            }
            // console.log(arr)
            this.orders=arr
            
          }
        })
        .catch(err=>{
          console.log(err.message)
        })


      },
      editItem (item) {
        this.editedIndex = this.orders.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.orders.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.orders.splice(index, 1)
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.orders[this.editedIndex], this.editedItem)
        } else {
          this.orders.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>