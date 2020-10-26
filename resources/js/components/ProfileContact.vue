<template>
    <div>
        <b-modal id="profile-contact-modal" title="Contact"
            :hide-footer="true"
        >
            <div class="alert alert-success" v-if="submitted">Your message was sent. Thanks!</div>
            <div class="alert alert-danger" v-if="err">Error. Your message was not sent please try again later.</div>
            <div class="alert alert-danger" v-if="!emailVerified">You have to verify your email address 
                for contacting with service provider</div>
            <ValidationObserver ref="observer">
                <form action="" method="" ref="form" v-if="!submitted">
                    <div class="form-group">
                        <label>* From</label>
                        <input type="email" class="form-control" disabled :value="fromEmail">
                    </div>
                    <div class="form-group">
                        <label>* Phone NO.</label>
                        <ValidationProvider rules="required" v-slot="{ errors }" name="Phone">
                            <input type="text" class="form-control" v-model="phone">
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <div class="mb-2">
                            <span class="btn btn-outline-secondary btn-sm" 
                                @click="set_message">Hello message</span>
                        </div>
                        <ValidationProvider rules="required" v-slot="{ errors }" name="Message">
                            <textarea name="" rows="5" class="form-control" 
                                v-model="message"></textarea>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" @click.prevent="send_message"
                            :disabled="submitting"
                        >
                            Send <i class="fas fa-spinner fa-spin" :class="{'d-none': !submitting}"></i>
                        </button>
                    </div>
                </form>
            </ValidationObserver>
        </b-modal>
    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend, validate } from 'vee-validate';
import { Validator } from 'vee-validate';
import { setInteractionMode } from 'vee-validate';
import en from 'vee-validate/dist/locale/en';
import * as rules from 'vee-validate/dist/rules';
setInteractionMode('eager');
for (let rule in rules) {
    extend(rule, {
        ...rules[rule], // add the rule
        message:  en.messages[rule] // add its message
    });
}

export default {
    components: {
        ValidationProvider, 
        ValidationObserver
    },
    props: {
        'from-email': {type: String},
        'post-id': {type: String},
        'email-verified': {type: Boolean, default: false}
    },
    data: function(){
        return {
            message: '',
            phone: '',
            submitting: false,
            submitted: false,
            err: false
        };
    },
    mounted(){
        // this.
    },
    methods: {
        /**
         * 
         */
        set_message(){
            this.message = 'Hi , i want your service please contact me on my phone or email provided above';
        },

        /**
         * 
         */
        async send_message()
        {
            this.submitting = true;
            const isValid = await this.$refs.observer.validate();

            if(isValid)
            {
                axios.post('/post-detail/contact', {
                        'message': this.message, phone: this.phone, post_id: this.postId
                    })
                    .then(resp => {
                        if(resp.status == 200){
                            this.submitted = true;
                            this.err = false;
                        }     
                    })
                    .catch((err) => {
                        this.submitted = false
                        this.err = true;    
                    })
                    .then(() => this.submitting = false);   
            }
            else
            {
                this.submitting = false;
            }
        }
    }
}
</script>

<style>

</style>