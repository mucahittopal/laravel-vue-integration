<template>
    <div>
        <vue-phone-number-input
            v-model="number" 
            :disabled="!onlyCountries"
            :only-countries="onlyCountries"
            @update="update"
            default-country-code="US"
        />
        <input type="hidden" :name="name" :value="value">
    </div>
</template>

<script>
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

export default {
    components: {
        'vue-phone-number-input': VuePhoneNumberInput
    },
    props: {
        name: {type: String},
    },
    data()
    {
        return{
            number: '',
            onlyCountries: [],
            value: '',
        };
    },
    computed: {

    },
    mounted(){
        axios.post('/api/countries').then((resp) => {
            if(resp.data) this.onlyCountries = resp.data.map((r) => {return r.name_code});
        })
    },
    methods: {
        update(payload)
        {
            if(payload.isValid){
                this.value = payload.formattedNumber;
            }
        }
    }
}
</script>

<style>

</style>