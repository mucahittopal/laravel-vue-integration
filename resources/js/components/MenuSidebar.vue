<template>
    <b-sidebar
        id="menu-sidebar"
        title=""
        backdrop
        right
        shadow
        header-class="mobile-menu-sidebar-header"
    >
        <b-list-group class="listgroup">
            <b-list-group-item href="/login" v-if="!auth">Sign In / Sign Up</b-list-group-item>
            <b-list-group-item :class="{'is-open': active_menu == 'profile'}"
                v-if="auth"
            >
                <div class="d-flex justify-content-between align-ietsm-center"
                    :class="{'pb-2': active_menu == 'profile'}"
                    @click="active_menu = active_menu != 'profile' ? 'profile' : ''"
                >
                    <span>Hello, {{authName}}</span>
                    <span><i class="fas fa-chevron-right"></i></span>
                </div>
                <b-list-group class="sublist">
                    <b-list-group-item href="/home">Account</b-list-group-item>
                    <b-list-group-item href="/provide-service" v-if="authProvideService">Provide Service</b-list-group-item>
                    <b-list-group-item href="/edit-service" v-if="!authProvideService">Edit Service</b-list-group-item>
                    <b-list-group-item onclick="document.getElementById('logout-form').submit()">Log out</b-list-group-item>
                </b-list-group>
            </b-list-group-item>
            <b-list-group-item :class="{'is-open': active_menu == 'location'}">
                <div class="d-flex justify-content-between align-ietsm-center"
                    :class="{'pb-2': active_menu == 'profile'}"
                    @click="active_menu = active_menu != 'location' ? 'location' : ''"
                >
                    <span>
                        {{selected_country_name}}
                    </span>
                    <span><i class="fas fa-chevron-right"></i></span>
                </div>
                <b-list-group class="sublist">
                    <b-list-group-item v-for="(r,i) in countryChangeLinks" :href="'/?' + r" :key="'ccl-' + i">
                        {{countries[i].name}}
                    </b-list-group-item>
                </b-list-group>
            </b-list-group-item>
            <b-list-group-item href="/provide-service" v-if="authProvideService">Provide service</b-list-group-item>
            <b-list-group-item href="javascript:;" 
                onclick="document.getElementById('logout-form').submit()"
                v-if="auth"
            >Logout</b-list-group-item>
        </b-list-group>
    </b-sidebar>
</template>

<script>
export default {
    props: {
        'auth-name': {type: String, default: ''},
        countries: {type: Array},
        'country-change-links': {type: Array},
        'request-country-id': {type: Number},
        'auth': {type: Boolean, default: false},
        'auth-provide-service': {type: Boolean, default:false}
    },
    data(){
        return {
            active_menu: '',
        };
    },
    computed: {
        selected_country_name(){
            let country = this.countries.find((item) => {return item.id == this.requestCountryId});
            return country ? country.name : 'USA';
        }
    },
    mounted()
    {
        //
    },
    methods: {
        
    }
}
</script>

<style scoped>
    .mobile-menu-sidebar-header{
        background-color: #1652F0;
    }

    .mobile-menu-sidebar-header button svg{
        fill: #fff;
    }

    .listgroup{
        border-radius: 0;
    }

    .listgroup .list-group-item{
        border-left: 0;
        border-right: 0;
    }

    .sublist{
        display: none;
    }

    .is-open .sublist{
        display: block;
    }

    .sublist .list-group-item{
        border-top: 0;
        border-left: 0;
        border-right: 0;
    }

    .sublist .list-group-item:last-child{
        border-bottom: 0;
    }
</style>