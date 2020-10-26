<template>
    <div>
        <form action="/login" method="post" ref="form">
            <input type="hidden" name="_token" :value="csrfToken">
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label font-bold">
                    Email Address
                </label>

                <div class="col-md-8">
                    <input id="email" 
                        type="email" 
                        class="form-control" 
                        name="email" 
                        v-model="email"
                        required 
                        :class="{
                            'is-invalid': err_msg
                        }"
                        @input="input"
                    >
                    <div class="invalid-feedback" :class="{ 'd-block' : err_msg }">
                        {{ err_msg }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label font-bold">Password</label>

                <div class="col-md-8">
                    <input id="password" type="password" 
                        class="form-control" 
                        name="password" required 
                        v-model="password"
                        
                    >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-group">
                        <p-check color="primary" name="remember" v-model="remember">Remember me</p-check>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" @click.prevent="submitForm"
                        :disabled="is_submitting"
                    >
                        Sign In
                        <span :class="{'d-none': !is_submitting}"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>

                    <a class="btn btn-link" href="/password/reset">
                        Forgot your password?
                    </a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import PrettyCheck from 'pretty-checkbox-vue/check';

export default {
    components: {
        'p-check': PrettyCheck,
    },
    props: {
        'csrf-token': {required: true},
        'err-login': {type: String}
    },
    data(){
        return {
            email: '',
            password: '',
            remember: false,
            err_msg: '',
            is_submitting: false
        }
    },
    mounted()
    {
        // console.log('mounted');
    },
    methods: {
        async submitForm()
        {
            if(this.email && this.password)
            {
                this.err_msg = '';
                this.is_submitting = true;

                await axios.post('/api/credential-exist', {email: this.email, password: this.password})
                    .then((resp) => {
                        this.err_msg = resp.data == 'not exist' ? 'These credentials do not match our records' : '';
                    }).catch((err) => {
                        this.err_msg = 'These credentials do not match our records';
                    })

                if(!this.err_msg){
                    this.$refs.form.submit();
                }else{
                    this.is_submitting = false;
                }
            }
        },

        input()
        {
            this.err_msg = this.err_msg ? '' : this.err_msg;
        }
    }
}
</script>

<style>

</style>