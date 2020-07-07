<template>
  <v-container class="flex-column">
			<v-navigation-drawer
					v-model="rd" 
					fixed
					temporary 	
					right
				>
				<v-col v-if="cart.length!=0">
					<v-row
						v-for="(item,i) in cart"
						:key="i"
						>
						<v-card flat outlined width="100%" class="pa-0 mb-1">
							<v-col>
								<v-row>
									<v-img max-width="75" aspect-ratio="1" contain :src="'/img/'+item.image"></v-img>
									<v-divider vertical class="mx-2"></v-divider>
									<v-col class="grow flex-column pa-1">
										<v-card-text v-text="item.pizza_name" class="py-1"></v-card-text>
										<v-card-subtitle v-text="item.pizza_desc" class="py-1"></v-card-subtitle>
									</v-col>
								</v-row>
								<v-row class="d-flex align-center pa-0">
									<v-col class="align-center pa-0">
										<v-row justify="center" v-text="'Price: € '+ (item.price)"></v-row>
									</v-col >
									<v-col class="align-center justify-end d-flex pa-0" >
										<!-- <v-row justify="center" class="text-right" v-text="'Qty'"></v-row> -->
											<v-col class="pa-0 d-flex align-center justify-center" >
												<v-text-field v-text="'Qty: '+item.quantity" class="pa-0 ma-0 shrink justify-center text-center"></v-text-field>
											</v-col>
										
									</v-col>
								</v-row>

							</v-col>
						</v-card>
					</v-row>
					
					<v-row class="py-6" justify="center" v-text="'Pay : € ' + bill"></v-row>
					<v-row justify="center">
						<v-form method="POST" action="/order/create" enctype='multipart/form-data/application/json'>
							<input type="hidden" name="_token" :value="csrf">
							<input type="hidden" name="order" :value="order">
							<v-btn type=submit class="primary">Buy Now</v-btn>
						</v-form>

					</v-row>
				</v-col>
				<v-container fill-height v-else>
					<v-col>
							<v-row justify="center" class=" text-center headline">
								<v-icon large>mdi-cart-off</v-icon>
							</v-row>
							<v-row justify="center" class=" text-center headline">
								Your Cart is empty
							</v-row>
							<v-row justify="center" class=" text-center subtitle">
								Please add items and view here
							</v-row>

					</v-col>
				</v-container>
			</v-navigation-drawer>
      <v-col class="shrink">
          <v-row justify="center" class="text-center"><h1>Pizza Menu</h1></v-row>
          <v-row justify="center" class="text-center"><span>Just Add to Cart and Order. It's that simple</span></v-row>
      </v-col>
			<v-row justify="center" class="mb-12">
				<v-hover
					v-for="(pizza,i) in pizzas"
					:key="i"
					v-slot:default="{ hover }"
					>
					<v-card
						width="250"
						height="300"
						:elevation="hover ? 24 : 4"
						hover
						class="ma-6 mb-12"
						
						
						>
						<v-container class="fill-height flex-column pa-0">
							<v-col class="pa-0 shrink">
								<v-img
									:src="'/img/'+pizza.image"
									height="200"
									width="250"
									contain
									class="align-end"
									>
									<v-card-title v-text="pizza.pizza_name" class="justify-center pa-0 ma-0"></v-card-title>
								</v-img>
								<v-divider class="pa-0 ma-0"></v-divider>
							</v-col>
							<v-col class="grow">
								<v-container class="pa-0 fill-height align-end">
									<v-row justify="center">
										<v-card-subtitle class="pa-0 text-center" v-text="pizza.pizza_desc"></v-card-subtitle>
									</v-row>
									<v-row>
										<v-card-text class="pa-0 ma-0">
											<v-row class="align-center">
													<v-col class="align-center pa-0">
														<v-row justify="center" v-text="'Price: € '+ (pizzas[i].price)"></v-row>
													</v-col >
													<v-col class="pa-0" >
														<v-row class="justify-center align-center" >
																Qty:
																<v-btn small icon @click="decQuantity(i)"><v-icon small >mdi-minus</v-icon></v-btn>
																<v-row class="pa-0 ma-0 shrink justify-center text-center">{{pizza.quantity}}</v-row>
																<v-btn small icon @click="incQuantity(i)"><v-icon small>mdi-plus</v-icon></v-btn>
														</v-row>
													</v-col>
											</v-row>
										</v-card-text>
									</v-row>
									<v-row>
										
									</v-row>
								</v-container>

							</v-col>
							
						</v-container>
						<v-btn block :elevation="hover ? 24 : 4" @click="addtocart(pizza,i)" :color="updated[i].flag?'warning':'primary'">{{updated[i].text}}</v-btn>
					</v-card>
				</v-hover>
			</v-row>
  </v-container>
</template>

<script>

export default {
	// props:['numitems','rightdrawer','shopcart'],
	props:['rdrawer','nitems'],

	data(){
		return{
			pizzas: [],
			cart:[],
			bill:0,
			order:{
				items:[],
				bill_amount:0,
			},
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
			updated:[],      
		}
	},	

	mounted(){
		
		// this.$root.$set(this.$root.$data,'ordercart',2)
		// console.log(this.$root.$data.ordercart)
		
		let p=[]
		axios.get('getpizza')
		.then(res=>{
			res.data.forEach(pizza => {
				pizza.quantity=0
				p.push(pizza)
				this.updated.push({
					flag:false,
					text:'Add to Cart'
				})

			})
		})
		.catch(err=>{
			console.log(err.response)
		})
		this.pizzas=p
	},


	computed: {
    rd: {
        get() { return this.rdrawer },
        set(rd) {this.$emit('update:rdrawer', rd)}
    },
    numi: {
        get() { return this.nitems },
        set(numi) {this.$emit('update:nitems', numi)}
    }
	},

	watch:{
		
	},

	methods:{
		
		createOrder(){
			let totalprice=0
			let order = {
				items:[],
				bill_amount:0
			}
			this.cart.forEach(pizza => {
				order.items.push(pizza)
				totalprice+=pizza.quantity*pizza.price				
			})
			totalprice= Math.ceil(totalprice * Math.pow(10, 2)) / Math.pow(10, 2);
			order.bill_amount=totalprice
			this.bill=totalprice
			this.order=JSON.stringify(order)
			
		},

		addtocart(pizza,i){
			
			
			if(pizza.quantity>0){	
				if(this.cart.length!=0){
					let existing=this.cart.filter(c=>c.pizza_id==pizza.pizza_id)
					if(existing.length!=0){
						let index=this.cart.indexOf(pizza)
						this.cart[index].quantity=this.pizzas[i].quantity

					}
					else{
						this.cart.push(pizza)
					}
				}else{
					this.cart.push(pizza)
				}
				this.updated[i].flag=true
				this.updated[i].text='Update Quantity'
				this.createOrder()
			}
			let numi=0
			this.cart.forEach(element => {
				numi+=element.quantity
			})
			this.numi=numi

			
		},

		incQuantity(i){
			this.pizzas[i].quantity+=1
		},

		decQuantity(i){
			
			
			if(this.pizzas[i].quantity!=0){
				this.pizzas[i].quantity-=1
				let index=this.cart.indexOf(this.pizzas[i])
				this.cart[index].quantity=this.pizzas[i].quantity
				if(this.cart[index].quantity==0){
					this.cart.splice(i,1)
					this.updated[i].flag=false
					this.updated[i].text='Add to Cart'
				}
			}
			let numi=0
			this.cart.forEach(element => {
				numi+=element.quantity
			})
			this.numi=numi
			this.createOrder()

		}
	}


}
</script>

<style>

</style>