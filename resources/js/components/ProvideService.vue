<template>
    <div>
        <ValidationObserver ref="observer">
            <form action="/posts" ref="form" method="post" enctype="multipart/form-data">
                <p>* signed boxes are mandatory</p>

                <input type="hidden" name="_token" :value="csrfToken">
                <input type="hidden" name="recaptcha_token" id="recaptcha-token">

                <!-- country -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Country</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|integer" v-slot="{ errors }" name="Country">
                            <select name="country_id" class="form-control" v-model="country_id"
                                @change="country_changed"
                                :disabled="!countries.length"
                            >
                                <option value=""></option>
                                <option v-for="country in countries" :key="'country-' + country.id" :value="country.id">
                                    {{country.name}}
                                </option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <!-- state -->
                <!-- <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* State</label>

                    <div class="col-md-8">
                        <ValidationProvider :rules="country_states.length ? 'required|integer' : ''" v-slot="{ errors }" name="State">
                            <select name="state_id" class="form-control" v-model="state_id"
                               :disabled="!country_states.length" 
                               @change="state_changed"
                            >
                                <option value="">Please select</option>
                                <option v-for="state in country_states" :key="'state-' + state.id" :value="state.id">
                                    {{state.name}}
                                </option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div> -->

                <!-- city -->
                <!-- <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* City</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|integer" v-slot="{ errors }" name="City">
                            <select name="city_id" class="form-control" v-model="city_id"
                                @change="city_changed"
                                :disabled="!cities.length"
                            >
                                <option value="">Please select</option>
                                <option v-for="city in cities" :key="'city-' + city.id" :value="city.id">{{city.name}}</option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                               {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div> -->
                
                <!-- zip code -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Zipcode</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|integer" v-slot="{ errors }" name="Zip Code">
                            <select name="zipcode_id" class="form-control" v-model="zipcode_id"
                                :disabled="!zipcodes.length"
                            >
                                <option value="">Please select</option>
                                <option v-for="zipcode in zipcodes" :key="'zipcode-' + zipcode.id" :value="zipcode.id">
                                    {{zipcode.code}}
                                </option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                
                <!-- gender -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Gender</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|oneOf:male,female" v-slot="{ errors }" name="Gender">
                            <select name="gender" class="form-control" v-model="gender">
                                <option value="">Please select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <!-- spoken languages -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Spoken Languages</label>

                    <div class="col-md-8">
                        <ValidationProvider rules="required|max-select:5" v-slot="{ errors }" name="Spoken Languages">
                            <multiselect 
                                v-model="spoken_languages"
                                placeholder="Please choose up to 5" label="name" track-by="name" 
                                :options="languages" :multiple="true" :taggable="true"
                                :max="5"
                                :disabled="!languages.length"
                            >
                            </multiselect>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                        <input type="hidden" name="spoken_languages[]" v-for="sl in spoken_languages"
                            :key="'sl-' + sl.name" :value="sl.id"
                        >
                    </div>
                </div>
                
                <!-- services-->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Offered Services</label>

                    <div class="col-md-8">
                        
                        <ValidationProvider rules="required|max-select:5" v-slot="{ errors }" name="Service Offer">
                            <multiselect 
                                v-model="services_offer"
                                placeholder="Please choose up to 5" label="name" track-by="name" 
                                :options="services" :multiple="true" :taggable="true"
                                :max="5"
                                :disabled="!services.length"
                            >
                            </multiselect>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                        <input type="hidden" name="services_offer[]" v-for="so in services_offer"
                            :key="'so-' + so.name" :value="so.id"
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Cost per Hour ($)</label>
                    <div class="col-md-8">
                        <ValidationProvider rules="required|integer|min:0" v-slot="{ errors }" name="Cost per hour">
                            <div>{{hourly_rate}}$</div>
                            <b-form-input type="range" min="0" max="100" v-model="hourly_rate" name="hourly_rate"></b-form-input>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Experience (years)</label>
                    <div class="col-md-8">
                        <ValidationProvider rules="required|integer|min:0|max:20" v-slot="{ errors }" name="Experience years">
                            <select name="experience" class="form-control" v-model="experience_years">
                                <option value="">Please select</option>
                                <option value="0">0</option>
                                <option v-for="n in 20" :key="'experience-' + n" :value="n">{{n}}</option>
                            </select>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Description</label>
                    <div class="col-md-8">
                        <ValidationProvider rules="required" v-slot="{ errors }" name="Description">
                            <textarea name="description" class="form-control" v-model="description" rows="10"></textarea>
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-bold">* Phone no.</label>
                    <div class="col-md-8">
                        <vue-phone-number-input 
                            :fetch-country="false"
                            :only-countries="countries_alpha2_names"
                            default-country-code="US"
                            v-model="vue_phone_input"
                            @update="phone_input"
                        ></vue-phone-number-input>
                        <ValidationProvider rules="required" v-slot="{ errors }" name="Phone No.">
                            <input type="hidden" name="phone" v-model="phone_number">
                            <div class="invalid-feedback" :class="{ 'd-block' : errors[0] }">
                                {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right font-bold">Profile Photo</label>
                    <div class="col-md-8">
                        <input type="file" allowed="images/png,images/jpeg,images/jpg" 
                            name="profile_photo"
                        >
                        <div>
                            <span class="font-bold">Notes: </span>
                            <ul>
                                <li>- Max file size can be 15mb</li>
                                <li>- Allowed extension are jpeg,jpg,png</li>
                                <!-- <li>- Upload square image which same height and same width. for example 500x500</li> -->
                                <li>- Minimum image dimesion is 250x250</li>
                                <li>- New uploaded profile photo will be visible after admin verification</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right font-bold">Onsite Service</label>
                    <div class="col-md-8">
                        <select name="onsite_service" class="form-control" v-model="onsite_service">
                            <option value=""></option>
                            <option value="1">Yes</option>
                            <option value="0">no</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right font-bold">How did you hear us?</label>
                    <div class="col-md-8">
                        <select name="referrer_id" class="form-control" v-model="hear_us_from"
                            :disabled="!referrers.length"
                        >
                            <option value=""></option>
                            <option v-for="referrer in referrers" :key="referrer.name" :value="referrer.id">{{referrer.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right font-bold">Reference</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="reference"
                            maxlength="45" name="reference"
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button class="btn btn-primary btn-block"
                            @click.prevent="submitForm"
                            :disabled="submitting"
                        >
                            Submit <span :class="{'d-none': !submitting}"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </div>
</template>











<script>
import Multiselect from 'vue-multiselect'
// import {VueTelInput} from 'vue-tel-input'
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import PrettyCheck from 'pretty-checkbox-vue/check';
import { ValidationProvider, ValidationObserver, extend, validate } from 'vee-validate';
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
extend('uniqueEmail', {
    async validate(value) {
        if(value)
        {
            // You might want to check if its a valid email
            // before sending to server...
            const { data } = await axios.post('/api/isEmailUnique', { value });
            // server response
            if (data.valid) {
                return true;
            }
            return {
                valid: false,
                // the data object contents can be used in the message template
                data: {
                    // error: data.error
                    error: 'Email istifadə olunur'
                }
            };
        }
    },
    message: `{error}` // will display the server error message.
});
// checked
extend('checked', (value) => {
    if(value) return true;
    return 'The {_field_} must be checked';
});
extend('max-select', {
    validate: (value, {length}) => {
        if(value.length <= length) return true;
        return 'You can choose up to ' + length + ' values';
    },
    params: ['length']
})

export default {
    components: { 
        Multiselect,
        // 'vue-tel-input': VueTelInput,
        'p-check': PrettyCheck,
        'vue-phone-number-input': VuePhoneNumberInput,
        // vUploader,
        ValidationProvider, 
        ValidationObserver,
    },
    props: {
        'csrf-token': {type: String, required: true},
        'upload-profile-photo': {type: Boolean, default: false},
    },
    data()
    {
        return {
            country_id: '',
            // state_id: '',
            // city_id: '',
            zipcode_id: '',
            gender: '',
            spoken_languages: [],
            services_offer: [],
            hourly_rate: 10,
            experience_years: '',
            description: '',
            phone_number: '',
            vue_phone_input: '',
            onsite_service: '',
            hear_us_from: '',
            reference: '',
            countries: [],
            // country_states: [],
            // country_cities: [],
            // city_zipcodes: [],
            zipcodes: [],
            languages: [],
            services: [],
            referrers: [],
            submitting: false,
        };
    },
    computed:{
        // cities: function(){
        //     if(this.country_cities){
        //         if(this.country_states.length){
        //             return this.country_cities.filter(city => {
        //                 return city.state_id == this.state_id
        //             })
        //         }else{
        //             return this.country_cities
        //         }
        //     }
        //     return [];
        // },
        countries_alpha2_names()
        {
            if(this.countries.length){
                return this.countries.map(item => {return item.name_code});
            }
            return [];
        }
    },
    mounted()
    {
        this.get_countries();
        this.get_languages();
        this.get_services();
        this.get_referrers();
        grecaptcha.ready(function() {
            grecaptcha.execute('6Lcn36UZAAAAAEP8KCyf4aFWmIfK40FDOl7ibyuv', {action: 'provide_service'})
                .then(token => document.getElementById('recaptcha-token').value = token);
        })
    },
    methods: {

        /**
         * getting countries with api call
         *
         */
        get_countries()
        {
            axios.get('/api/countries').then(resp => this.countries = resp.data.data)
                .catch((err) => console.log(err));
        },

        /**
         * 
         */
        get_languages()
        {
            axios.get('/api/languages').then(resp => this.languages = resp.data.data)
                .catch((err) => console.log(err));
        },

        /**
         * 
         */
        get_services()
        {
            axios.get('/api/services').then(resp => this.services = resp.data.data)
                .catch((err) => console.log(err));
        },

        /**
         * 
         */
        get_referrers()
        {
            axios.get('/api/referrers').then(res => {this.referrers = res.data.data})
                .catch((err) => console.log(err));
        },

        /**
         * 
         */
        country_changed()
        {
            this.zipcodes = [];
            // this.country_states = [];
            // this.country_cities = [];
            // this.city_zipcodes = [];
            // this.state_id = '';
            // this.city_id = '';
            this.zipcode_id = '';

            if(this.country_id){
                axios.get('/api/countries/' + this.country_id + '/zipcodes').then(resp => {
                    // this.country_states = resp.data.data.states;
                    // this.country_cities = resp.data.data.cities;
                    this.zipcodes = resp.data.data;
                }).catch((err) => console.log(err));
            }
        },

        /**
         * 
         */
        state_changed()
        {
            this.city_id = '';
            this.zipcode_id = '';
            this.city_zipcodes = [];
        },

        /**
         * 
         */
        city_changed()
        {
            this.zipcode_id = '';
            this.city_zipcodes = [];
            if(this.city_id){
                axios.get('/api/cities/' + this.city_id).then(resp => {
                    this.city_zipcodes = resp.data.data.zipcodes;
                }).catch((err) => console.log(err));
            }
        },

        /**
         * 
         */
        addTag (newTag) {
            console.log(newTag);
            // const tag = {
            //     name: newTag,
            //     code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            // }
            // this.options.push(tag)
            // this.value.push(tag)
        },

        /**
         * 
         * 
         */
        async submitForm()
        {
            this.submitting = true;
            const isValid = await this.$refs.observer.validate();

            await grecaptcha.ready(function() {
                grecaptcha.execute('6Lcn36UZAAAAAEP8KCyf4aFWmIfK40FDOl7ibyuv', {action: 'provide_service'})
                    .then(token => document.getElementById('recaptcha-token').value = token);
            });

            if(isValid)
            {
                // submit form
                this.$refs.form.submit();
            }
            else
            {
                this.submitting = false;
            }
        },

        /**
         * 
         */
        phone_input(payload)
        {   
            if(payload.isValid){
                this.phone_number = payload.e164;
            }else{
                this.phone_number = '';
            }
        },
    }
}
</script>

<style>

</style>