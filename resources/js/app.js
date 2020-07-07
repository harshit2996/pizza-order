require('./bootstrap');
<<<<<<< HEAD

window.Vue = require('vue');
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'


Vue.use(Vuetify)

const opts = {
    
}

export default new Vuetify(opts)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('login', require('./components/login.vue').default);
Vue.component('register', require('./components/register.vue').default);
Vue.component('users-list', require('./components/users-list.vue').default);
Vue.component('profile', require('./components/profile.vue').default);
Vue.component('success-dialog', require('./components/success-dialog.vue').default);
Vue.component('admin-menu', require('./components/admin-menu.vue').default);
Vue.component('admin-content', require('./components/admin-content.vue').default);
Vue.component('user-content', require('./components/user-content.vue').default);
Vue.component('profile-menu', require('./components/profile-menu.vue').default);
Vue.component('pizzas', require('./components/pizzas.vue').default);
Vue.component('create-pizza', require('./components/create-pizza.vue').default);
Vue.component('order-page', require('./components/order-page.vue').default);
Vue.component('all-orders', require('./components/all-orders.vue').default);
Vue.component('my-orders', require('./components/my-orders.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(opts),
    data:{
        maindrawer:true,
        rightdrawer:false,
        numItems:0,
        ordercart:[],
    },
});
=======
>>>>>>> parent of e154bf2... vue and vuetify added with login system
