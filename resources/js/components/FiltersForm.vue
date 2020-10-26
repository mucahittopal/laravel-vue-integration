<template>
    <div>
        <form action="/" method="get" >
            <input type="hidden" name="service" :value="requestService">
            <input type="hidden" name="location_type" :value="requestLocationType">
            <input type="hidden" name="location" :value="requestLocation">
            <input type="hidden" name="country_id" :value="requestCountryId">
            <input type="hidden" name="sort_by" :value="requestSortBy" v-if="requestSortBy">

            <div class="form-group row">
                <div class="col-sm-12"><span class="font-bold">Languages</span></div>
                <div class="col-sm-12">
                    <select-box placeholder="ANY" 
                        :searchable="true"
                        :multiple="true"
                        :select-limit="5"
                        v-model="selected_languages"
                        :value="selected_languages"
                        :options="languages"
                        value-label="id"
                    />
                    <input v-for="(r,i) in selected_languages" type="hidden" name="language_ids[]"
                        :key="'language-' + i" :value="r"
                    >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12"><span class="font-bold">Gender</span></div>
                <div class="col-sm-12">
                    <select v-model="gender" class="form-control form-control-sm"
                        name="gender"
                    >
                        <option value="">ANY</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Others</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12"><span class="font-bold">Cost ($)</span></div>
                <div class="col-sm-12">
                    <div class="px-1">
                        <vue-slider :min="0" :max="100" v-model="hourly_rate" 
                            :enable-cross="false"
                        />
                        <input type="hidden" name="hourly_rate_min" :value="hourly_rate[0]">
                        <input type="hidden" name="hourly_rate_max" :value="hourly_rate[1]">
                        <p>{{hourly_rate[0]}} ~ {{hourly_rate[1]}} USD/hour</p>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12"><span class="font-bold">Exp</span></div>
                <div class="col-sm-12">
                    <select v-model="experience_years" class="form-control form-control-sm"
                        name="experience_years"
                    >
                        <option value="">ANY</option>
                        <option value="1">0 - 5</option>
                        <option value="6">5 - 10</option>
                        <option value="11">10 +</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><span class="btn btn-outline-primary btn-sm btn-block" @click="reset">Reset</span></div>
                <div class="col-6"><button class="btn btn-primary btn-sm btn-block">Apply</button></div>
            </div>
        </form>
        <form action="/" method="get" ref="form">
        </form>
    </div>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

export default {
    components: {
        VueSlider
    },
    props: {
        'request-language-ids': {type: Array},
        'request-gender': {type: String},
        'request-hourly-rate-min': {type: Number},
        'request-hourly-rate-max': {type: Number},
        'request-service': {type: String},
        'request-location': {type: String},
        'request-location-type': {type: String},
        'request-country-id': {type: String},
        'request-sort-by': {type: String},
        'request-experience-years': {type: String}
    },
    data()
    {
        return {
            languages: [],
            gender: '',
            hourly_rate: [0,100],
            selected_languages: [],
            experience_years: '',
        };
    },
    computed: {
        
    },
    created(){
        
    },
    mounted(){
        axios.get('/api/languages').then(resp => this.languages = resp.data.data);
        if(this.requestLanguageIds){
            this.requestLanguageIds.forEach(item => {
                this.selected_languages.push(parseInt(item));
            })
        }
        this.gender = this.requestGender ? this.requestGender : '';
        this.hourly_rate = [
            this.requestHourlyRateMin ? parseInt(this.requestHourlyRateMin) : 0,
            this.requestHourlyRateMax ? parseInt(this.requestHourlyRateMax) : 100
        ];
        this.experience_years = this.requestExperienceYears ? this.requestExperienceYears : '';
    },
    methods: {
        /**
         * 
         */
        reset()
        {
            this.selected_languages = [];
            this.gender = '';
            this.hourly_rate = [0,100];
            this.experience_years = '';
            this.$refs.form.submit()
        }
    }
}
</script>

<style>

</style>