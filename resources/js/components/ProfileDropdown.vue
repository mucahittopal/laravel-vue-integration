<template>
    <div>
        <div class="pr_dr_wr">
            <b-dropdown size="sm" variant="link" 
                toggle-class="text-decoration-none profile-dropdown-btn"
                no-caret
                right
                ref="dropdown"
                @click="click"
            >
                <template v-slot:button-content>
                    <div class="dropdown-btn-placeholder with-image">
                        <div class="pl_text">
                            <span>Hello</span>
                            <span>Ozal</span>
                        </div>
                        <div class="pl_img">
                            <img src="/images/no-user.png" alt="no image">
                        </div>
                        <div class="pl-caret"><i class="fas fa-caret-down"></i></div>
                    </div>
                </template>
                <b-dropdown-item href="/home">Account</b-dropdown-item>
                <b-dropdown-item href="/provide-service">Provide service</b-dropdown-item>
                <b-dropdown-item href="javascript:;" onclick="document.getElementById('logout-form').submit()">Logout</b-dropdown-item>
            </b-dropdown>
        </div>
    </div>
</template>

<script>
import { isMobile } from 'mobile-device-detect';

export default {
    props: {

    },
    data() {
        return {};
    },
    methods: {
        click(){
            this.$refs.dropdown.visible = !this.$refs.dropdown.visible;
        },
        mouseover(){
            if(!isMobile)
                this.$refs.dropdown.visible = true;
        },
        mouseleave(){
            if(!isMobile) this.$refs.dropdown.visible = false;
        }
    }
}
</script>

<style>

</style>