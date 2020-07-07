<template>
  <v-container fill-height class="justify-center">
    <v-row justify="center" class="text-center">
      <h1>Add New Pizza</h1>
    </v-row>
    <v-row justify="center" class="text-center justify-center">

        <v-col cols="12" md="6" sm="12">
          <v-form method="POST" action="/pizza" enctype='multipart/form-data'>
            <input type="hidden" name="_token" :value="csrf">
            <v-text-field hide-detail outlined v-model="pizza_name" name="pizza_name" label="Pizza Name" :rules="[rules.required]"></v-text-field>
            <v-file-input accept="image/*" type="file" @change="onFileChange" outlined append-icon="mdi-image" label="Add an image" prepend-icon="" name="image" :rules="[rules.required]"></v-file-input>
            <v-textarea hide-detail maxlength=60 v-model="pizza_desc" counter :counter-value="max" outlined name="pizza_desc"  label="description" :rules="[rules.required]"></v-textarea>
            <v-text-field hide-detail outlined name="price" v-model="price" label="price" prepend-inner-icon="mdi-currency-eur" :rules="[rules.required]"></v-text-field>
            <v-row>
              <v-col class="red--text" v-text="message">
                
              </v-col>
            </v-row>
            <v-btn type="button" @click="addPizza" color='success'> Submit</v-btn>

          </v-form>
        </v-col>

      </v-row>
      <success-dialog :success="success" :message="'Pizza added Successfully'" :location="'/'"></success-dialog>
  </v-container>
</template>

<script>
export default {
  data(){
    return{
      pizza_name:'',
      success:false,
      image:'',
      pizza_desc:'',
      message:'',
      price:'',    
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      rules: {
        required: value => !!value || 'Required.',
      },      
    }
  },

  methods:{
    onFileChange(e) {
      
      this.image=e
    },

    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    addPizza(){
      this.message=''
      const formData=new FormData()
        formData.append('pizza_name',this.pizza_name)
        formData.append('image',this.image)
        formData.append('pizza_desc',this.pizza_desc)
        formData.append('price',this.price)

        axios.post('/pizza',formData)
            .then(res=>{
              if(res.data!=''){
              
                this.success=true
              }
            })
            .catch(err=>{
              this.message='Pizza already exists'
              console.log(err.response)
            })

    },

    max(e){
      if(e){
        return e.length
      }
      else{
        return 0
      }
      
    }
  }
}
</script>

<style>

</style>