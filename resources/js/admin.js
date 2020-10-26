/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * 
 * 
 */

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import { BootstrapVue } from 'bootstrap-vue'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'

Vue.use(BootstrapVue);

Vue.component('v-select', vSelect)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('cities-store-form', require('./components/CitiesStoreForm.vue').default);
Vue.component('phone-input', require('./components/PhoneInput.vue').default);
Vue.component('update-profile-photo', require('./components/UpdateProfilePhoto.vue').default);
Vue.component('edit-post', require('./components/EditPost.vue').default);
// setting / search
Vue.component('location-search-box', require('./components/LocationSearchBox.vue').default);
Vue.component('search-any', require('./components/SearchAny.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted()
    {    
        
    },
    methods: {
        show_confirm(title, text, icon, confirmButtonText, showCancelButton = true)
        {
            return Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: confirmButtonText,
                showCancelButton: showCancelButton,
            })
        },

        /**
         * Delete category
         * @param id
         */
        delete_category(id, name)
        {
            let form = document.getElementById('category-destroy-form-' + id);
            this.show_confirm('Delete the category', 
                `Do you want to delete the ${name} category?`, 
                'question', 'Delete'
            ).then((result) => {
                if(result.isConfirmed)  form.submit();
            })
        },

        /**
         * 
         * @param {*} formId 
         * @param {*} confirmTitle 
         * @param {*} confirmQst 
         * @param {*} confirmIcon 
         * @param {*} confirmButtonText 
         */
        confirm_form_before_submit(formId, confirmTitle, confirmQst, confirmIcon, confirmButtonText)
        {
            let form = document.getElementById(formId);
            this.show_confirm(confirmTitle, confirmQst, confirmIcon, confirmButtonText
            ).then((result) => {
                if(result.isConfirmed)  form.submit();
            })
        },

        /**
         * Restore category
         * @param id
         */
        restore_category(id, name)
        {
            let form = document.getElementById('category-restore-form-' + id);
            this.show_confirm('Restore the category', 
                `Do you want to restore the ${name} category?`, 
                'question', 'Restore'
            ).then((result) => {
                if(result.isConfirmed)  form.submit();
            })
        },
    }
});
  
