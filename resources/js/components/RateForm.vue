<template>
    <div>
        <ValidationObserver ref="observer">
            <form action="/reviews" method="post" ref="form">
                <slot name="top"></slot>
                <div class="form-group text-right">
                    <span class="rate-button"
                        v-for="n in 5"
                        :key="'star-' + n"
                        @click="click(n)"
                        
                    >
                        <i
                            :class="{
                                'far fa-star': n > rate,
                                'fas fa-star text-primary': n <= rate
                            }"
                        ></i>
                    </span>
                    <ValidationProvider rules="required|integer|min:1" v-slot="{ errors }" name="Rate">
                        <input type="hidden" name="rate" v-model="rate">
                        <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                            {{ errors[0] }}
                        </div>
                    </ValidationProvider>
                </div>
                <div class="form-group" v-if="rate > 0">
                    <ValidationProvider rules="max:150" v-slot="{ errors }" name="Text">
                        <textarea name="text" placeholder="comment" class="form-control" maxlength="150"
                            v-model="text"
                        ></textarea>   
                        <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                            {{ errors[0] }}
                        </div>     
                    </ValidationProvider>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-sm btn-primary" :disabled="rate < 1 || submitting"
                        @click.prevent="write_review"
                    >
                        write a review <i class="fas fa-spinner fa-spin" :class="{'d-none': !submitting}"></i>
                    </button>
                </div>
            </form>
        </ValidationObserver>
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
    data(){
        return {
            rate: 0,
            submitting: false,
            text: '',
        };
    },
    methods: {
        click(n){
            this.rate = this.rate == n ? n - 1: n;
        },

        async write_review(){
            this.submitting = true;
            const isValid = await this.$refs.observer.validate();

            if(isValid){
                this.$refs.form.submit();
            }else{
                this.submitting = false;
            }
        }
    }
}
</script>

<style>

</style>