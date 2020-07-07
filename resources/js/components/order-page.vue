<template>
  <v-container>
    <v-row class="text-center headline">
      <v-col>
        Enter your Details for Shipping
      </v-col>
      <v-btn href="/" color="primary">Back</v-btn> 
    </v-row>
    <v-divider></v-divider>
    <v-form ref="form" action="/order" method="POST" >
      <input type="hidden" name="_token" :value="csrf">
      <input type="hidden" name="order" :value="orderstring">
      <input type="hidden" name="bill" :value="bill">

      <v-col>
        <v-row>Personal Details</v-row>
        <v-divider></v-divider>
        <v-row>
          <v-text-field class="mx-6"  dense outlined v-model="name" name="name" label="Name" prepend-inner-icon="mdi-account"  :rules="[rules.required]"></v-text-field>
          <v-text-field class="mx-6"  dense outlined v-model="phone" name="phone" label="Phone" prepend-inner-icon="mdi-phone"  :rules="[rules.required]"></v-text-field>
          <v-text-field class="mx-6"  dense outlined v-model="email" name="email" label="Email" prepend-inner-icon="mdi-gmail"  :rules="[rules.required,rules.email]"></v-text-field>
        </v-row>

      </v-col>
      <v-col>
        <v-row>Address Details</v-row>
        <v-divider></v-divider>
        <v-row>
          <v-text-field class="mx-6"  dense outlined v-model="house" name="house" label="House Number" prepend-inner-icon="mdi-home"  :rules="[rules.required]"></v-text-field>
          <v-text-field class="mx-6"  dense outlined v-model="street" name="street" label="Street" prepend-inner-icon="mdi-map"  :rules="[rules.required]"></v-text-field>
        </v-row>
        <v-row>
          <v-text-field class="mx-6"  dense outlined v-model="city" name="city" label="City" prepend-inner-icon="mdi-map-marker"  :rules="[rules.required]"></v-text-field>
          <v-text-field class="mx-6"  dense outlined v-model="zipcode" name="zipcode" label="Zip Code" prepend-inner-icon="mdi-mailbox"  :rules="[rules.required]"></v-text-field>
        </v-row>
      </v-col>

      <v-col>
        <v-row> 
          <v-col>
            Order Review
          </v-col> 
          <v-col>
            <v-btn href="/" color="primary">Change</v-btn>
          </v-col> 
        </v-row>
        <v-divider></v-divider>
        <v-slide-group multiple show-arrows>
          <v-slide-item
            v-for="(item,i) in final_order.items"
            :key="i"
            >
              <v-card 
                flat
                outlined 
                width="300" 
                class="pa-1 mx-4">
                <v-container class="fill-height">
                    <v-row>
                      <v-img max-width="75" aspect-ratio="1" contain :src="'/img/'+item.image"></v-img>
                      <v-divider vertical class="mx-2"></v-divider>
                      <v-col class="grow flex-column pa-1">
                        <v-card-text v-text="item.pizza_name" class="py-1"></v-card-text>
                        <v-card-subtitle v-text="item.pizza_desc" class="py-1"></v-card-subtitle>
                      </v-col>
                    </v-row>
                    <v-row class="d-flex align-end pa-0">
                        <v-row justify="center" v-text="'Price: € '+ (item.price)"></v-row>
                        <v-row justify="center" v-text="'Qty: '+item.quantity"></v-row>
                    </v-row>
                </v-container>
              </v-card>

        
            </v-slide-item>
        </v-slide-group>

      </v-col>

      <v-col>
        <v-col>
          <v-row> Total Amount for Pizzas € : {{final_order.bill_amount}}</v-row>
          <v-row > Dilevery Charges  € : {{charge.amount}} <span :class="final_order.bill_amount>20?'success--text ml-4':'ml-4 warning--text'"> {{charge.message}}</span></v-row>
          <v-col>
            <v-row justify="center">
              <v-row v-text="'Total amount to be paid € :'+bill"></v-row>
              <v-btn color="primary" type="button" @click="placeorder"> Proceed to Pay</v-btn>
            </v-row>

          </v-col>
        </v-col>
      </v-col>
      <v-col>
        <v-col>
        </v-col>
      </v-col>

    </v-form>
      <success-dialog :success="success" :message="'Your Order has been placed Successfully'" :location="'/'"></success-dialog>
    
  </v-container>
</template>

<script>
export default {

  data(){
    return{
      success:false,
      final_order:[],
      charge:{
        amount:0,
        message:'Delivery free for orders of more than € 20.00'
      },
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      bill:0,
      orderstring:[],
      name:'',
      phone:'',
      email:'',
      address:'',
      house:'',
      street:'',
      city:'',
      zipcode:'',
      rules: {
        required: value => !!value || 'Required.',
        min: v => v.length >= 8 || 'Min 8 characters',
        email:value=>{
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        },
      },

    }
  },

  mounted(){
		// console.log(window.final_order)
    this.final_order=window.final_order
    if(this.final_order.bill_amount>20.00){
      this.charge.amount=0
      this.charge.message='Free'
    }
    else if(this.final_order.bill_amount>15.00){
      this.charge.amount=0.50
      this.charge.message='Delivery free for orders of more than € 20.00'
    }
    else if(this.final_order.bill_amount>10.00){
      this.charge.amount=0.75
      this.charge.message='Delivery free for orders of more than € 20.00'
    }
    else{
      this.charge.amount=1.5
      this.charge.message='Delivery free for orders of more than € 20.00'
    }

    this.bill=this.final_order.bill_amount+this.charge.amount
    this.orderstring=JSON.stringify(window.final_order)
    
  },

  methods:{
    validate(){
      this.$refs.form.validate()
    },

    placeorder(){
      if(this.$refs.form.validate()){
        const formData=new FormData()
        formData.append('name',this.name)
        formData.append('phone',this.phone)
        formData.append('email',this.email)
        formData.append('house',this.house)
        formData.append('street',this.street)
        formData.append('city',this.city)
        formData.append('zipcode',this.zipcode)
        formData.append('order',this.orderstring)
        formData.append('bill',this.bill)
  
  
        axios.post('/order',formData)
            .then(res=>{
              if(res.data!=''){
                this.message=res.data
              }
              else{
                this.success=true
              }
            })
            .catch(err=>{
              console.log(err.response)
            })

      }
    },

    
  }

}
</script>

<style>

</style>