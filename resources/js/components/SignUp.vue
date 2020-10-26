<template>
    <div>
        <ValidationObserver ref="observer">
            <form action="/register" method="post" ref="form">
                <input type="hidden" name="_token" :value="csrfToken">

                <!-- name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right font-bold">* Name</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|max:45" v-slot="{ errors }" name="Name">
                            <input 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                required autocomplete="name"
                                v-model="name"
                            />
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <!-- email address -->
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right font-bold">* Email Address</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|max:255|email|email-unique"
                            v-slot="{ errors }" name="Email"
                        >
                            <input id="email" type="email" class="form-control" 
                                name="email"  required autocomplete="email"
                                v-model="email"    
                            >
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right font-bold">* Password</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|min:8|max:15" vid="password"
                            v-slot="{ errors }" name="Password"
                        >
                            <input id="password" type="password" class="form-control" 
                                name="password" required autocomplete="new-password"
                                v-model="password"
                            >
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right font-bold">* Confirm Password</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|confirmed:password" 
                            v-slot="{ errors }" name="Password Confirmation"
                        >
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password"
                                v-model="password_confirmation"    
                            >
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <ValidationProvider rules="checked" v-slot="{ errors }" name="Agree to term and privacy">
                            <div>
                                I Agree to Desiworkforce
                                <a href="https://dwf-termsandcondition.s3.amazonaws.com/Terms+%26+Conditions.html"
                                target="_blank">Terms and Condition and Privacy Notice.</a>
                            </div>
                            <p-check name="check" color="primary" v-model="agree_term_privacy">
                                I agree
                            </p-check> 
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div> 
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <b-button block variant="primary" @click="submitForm"
                            :disabled="isSubmitting"
                        >
                            Sign up
                            <span :class="{'d-none': !isSubmitting}"><i class="fas fa-spinner fa-spin"></i></span>
                        </b-button>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import {VueTelInput} from 'vue-tel-input'
import PrettyCheck from 'pretty-checkbox-vue/check';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { Validator } from 'vee-validate';
import { setInteractionMode } from 'vee-validate';
import en from 'vee-validate/dist/locale/en';
import * as rules from 'vee-validate/dist/rules';
setInteractionMode('eager');
// import {vUploader} from 'v-uploader';
// loop over all rules
for (let rule in rules) {
    extend(rule, {
        ...rules[rule], // add the rule
        message:  en.messages[rule] // add its message
    });
}
// unique email
extend('email-unique', {
    validate: async function(value) 
    {
        if(value)
        {
            // You might want to check if its a valid email
            // before sending to server...
            let err_msg = '';
            await axios.post('/api/is-email-unique', { 'email': value }).then((resp) => {
                err_msg = resp.data ? 'Email already is in use' : '';
            }).catch((err) => {
                err_msg = err.response.data.errors.email[0]
            })
            return err_msg ? err_msg : true;
        }
    },
});
// checked
extend('checked', (value) => {
    if(value) return true;
    return 'The {_field_} must be checked';
});

export default {
    components: { 
        Multiselect,
        'vue-tel-input': VueTelInput,
        'p-check': PrettyCheck,
        // vUploader,
        ValidationProvider, 
        ValidationObserver
    },
    props: {
        'csrf-token': {type: String, required: true}
    },
    data()
    {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            agree_term_privacy: false,
            isSubmitting: false,
        };
    },
    methods: {
        /**
         * 
         * 
         */
        async submitForm()
        {
            this.isSubmitting = true;
            const isValid = await this.$refs.observer.validate(true);

            if(isValid)
            {
                // submit form
                this.$refs.form.submit();
            }
            else
            {
                this.isSubmitting = false;
            }
        }
    }
}
</script>

<style>

</style>