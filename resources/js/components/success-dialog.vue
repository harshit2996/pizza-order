<template>
  <div class="text-center">
    
    <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"

    >
        <v-card class="ma-0 pa-0">
          <v-container>
            <v-img
              contain
              height="128"
              src="/img/logo.png"
            ></v-img>

          </v-container>
          <v-card-text>
            <v-row justify="center" class="title text-center font-weight-light success--text" v-text="msg"></v-row>
          </v-card-text>
          <v-divider class="my-0"></v-divider>
          <v-card-actions class="pa-0 ma-0">
            <v-col>
              <v-row justify="end">
                <v-btn text :href="loc">
                  Return
                </v-btn>
              </v-row>
            </v-col>
          </v-card-actions>
        </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props:['success','message', 'location','order_id'],
    
    data () {
      return {
        // dialog: false,
      }
    },

    computed: {
      dialog: {
        get() { return this.success },
        set(dialog) {this.$emit('update:success', dialog)}
      },

      msg: {
        get() { return this.message },
        set(msg) {this.$emit('update:message', msg)}
      },
      loc: {
        get() { return this.location },
        set(loc) {this.$emit('update:location', loc)}
      },
      id: {
        get() { return this.order_id },
        set(id) {this.$emit('update:order_id', id)}
      },
        
    },
  }
</script>