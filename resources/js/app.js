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
import { BootstrapVue } from 'bootstrap-vue'
import VueClipboard from 'vue-clipboard2'


Vue.use(BootstrapVue);
Vue.use(VueClipboard)

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
Vue.component('menu-sidebar', require('./components/MenuSidebar.vue').default);
// Vue.component('profile-dropdown', require('./components/ProfileDropdown.vue').default);
Vue.component('filters-form', require('./components/FiltersForm.vue').default);
Vue.component('select-box', require('./components/SelectBox.vue').default);
Vue.component('social-share-box', require('./components/SocialShareBox.vue').default);
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('sign-up', require('./components/SignUp.vue').default);
Vue.component('auth-form', require('./components/AuthForm.vue').default);
Vue.component('image-gallery', require('./components/ImageGallery.vue').default);
Vue.component('rate-form', require('./components/RateForm.vue').default);
Vue.component('profile-contact', require('./components/ProfileContact.vue').default);
Vue.component('provide-service', require('./components/ProvideService.vue').default);
Vue.component('edit-post', require('./components/EditPost.vue').default);
Vue.component('provide-service-alert', require('./components/ProvideServiceAlert.vue').default);
Vue.component('update-profile-photo', require('./components/UpdateProfilePhoto.vue').default);
Vue.component('location-search-box', require('./components/LocationSearchBox.vue').default);
Vue.component('post-reviews', require('./components/PostReviews.vue').default);
Vue.component('custom-pagination', require('./components/CustomPagination.vue').default);
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
        window.addEventListener('click', event => {
            this.$emit('windowclick', event)
        });

        window.addEventListener('scroll', event => {
            this.quick_search_fixed(event);
        });

        window.addEventListener('resize', event => {
            this.quick_search_fixed(event);
        })
    },
    methods: {
        /**
         * 
         */
        open_filter_form(){
            // console.log(document.getElementById('filterFormWrapper'))
            document.getElementById('filterFormWrapper').classList.toggle('d-none');
            document.getElementById('filterFormWrapper').classList.toggle('d-sm-none');
            if (this.filterLabel == 'Filters') {
                this.filterLabel = 'Close Filters'
            } else {
                this.filterLabel = 'Filters'
            }
        },

        /**
         * 
         */
        quick_search_fixed(event)
        {
            // console.log(window.scrollY);
            let element = document.getElementById('filterFormWrapper');
            if(element)
            {
                var el_offset_top = window.screen.width > 991 ? 120 : 150;
                var style_top = el_offset_top > window.scrollY 
                    ? el_offset_top - window.scrollY : 0;
                // console.log(style_top);
                // console.log(element_computed_style.top);
                if(window.screen.width < 768){
                    style_top = 0;
                }
                element.style.top = style_top + 'px';
            }
        },
    }, 
    data: {
        filterLabel: 'Filters', // "Close Filters"
    }
});
  
