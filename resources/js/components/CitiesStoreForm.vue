<template>
    <div>
        <form :action="action" method="post">
            <slot name="form-top"></slot>
            <div class="form-group row">
                <label class="col-sm-5">* Name</label>
                <div class="col-sm-7">
                    <input type="text" name="name" 
                        class="form-control"
                        :class="{'is-invalid': errorName}" 
                        maxlength="45" 
                        required
                        v-model="name"
                    >
                    <div class="invalid-feedback" :class="{'d-block': errorName}">{{errorName}}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5">* Country</label>
                <div class="col-sm-7">
                    <select name="country_id" 
                        class="form-control" 
                        required
                        v-model="country_id"
                    >
                        <option value="">Please select</option>
                        <option v-for="country in countries" :key="'country_' + country.id" :value="country.id">
                            {{country.name}}
                        </option>
                    </select>
                    <div class="invalid-feedback" :class="{'d-block': errorCountry}">{{errorCountry}}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-5">State</label>
                <div class="col-sm-7">
                    <select name="state_id" 
                        class="form-control"
                        v-model="state_id"
                        :disabled="!this.country_id"
                    >
                        <option value="">Please select</option>
                        <option v-for="state in countryStates" :key="'state_' + state.id" :value="state.id">
                            {{state.name}}
                        </option>
                    </select>
                    <div class="invalid-feedback" :class="{'d-block': errorState}">{{errorState}}</div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        action: {type:String, required:true},
        'error-name': {type: String},
        'error-country': {type: String},
        'error-state': {type: String},
        countries: {required: true},
        states: {type:Array},
        city: {type: Object},
    },
    data()
    {
        return {
            name: '',
            country_id: '',
            state_id: ''
        };
    },
    computed: {
        countryStates(){
            return this.states.filter(element => {
                return element.country_id == this.country_id
            });
        }
    },
    mounted()
    {
        if(this.city){
            this.name = this.city.name;
            this.country_id = this.city.country_id;
            this.state_id = this.city.state_id;
        }
    },
    methods: {

    }
}
</script>

<style>

</style>