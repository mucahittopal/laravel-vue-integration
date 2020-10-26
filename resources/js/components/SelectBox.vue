<template>
    <div>
        <div class="selectbox-wrapper">
            <div class="custom-form-control form-control form-control-sm">
                <span class="caret"><i class="fas fa-caret-down"></i></span>
                <div class="custom-dropdown-btn"
                    :class="classlist"
                >
                    {{selected_display_text ? selected_display_text : placeholder}}
                </div>
            </div>
            <div class="options-wrapper searchable cbox-l1 content_of_dropdown"
                :class="{'is-shown': visible}"
            >
                <div class="header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="font-bold">{{placeholder}}</span>
                        <span><i class="fas fa-times"></i></span>
                    </div>
                </div>
                <div class="filter-options" v-if="searchable">
                    <input type="text" v-model="search_word" class="ms_search">
                </div>
                <ul class="optionslist "
                    :class="{'is-disabled': multiple && selectLimit && value.length == selectLimit}"
                >
                    <li v-for="(o,i) in options" :key="i"
                        class="ms_option"
                        :class="{
                            'd-none': !filter_string(o.name),
                            'selected': value.indexOf(o[valueLabel]) > -1
                        }"
                        @click="select_option(i)"
                    >
                        {{o.name}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        searchable: {type: Boolean, default: false},
        multiple: {type: Boolean, default: false},
        'select-limit': {type: Number, default: null},
        placeholder: {type: String},
        value: {required: false},
        options: {required:true, type:Array},
        'value-label': {type:String, default: 'value'}
    },
    data()
    {
        return {
            visible: false,
            search_word: '',
        };
    },
    computed: {
        selected_display_text(){
            let text = '';
            if(!this.multiple){
                var option = this.options.find((o,i) => o.value == this.value)
                text = option ? option.name : '';
            }else{
                if(this.value.length > 0){
                    var option = this.options.find((o,i) => o[this.valueLabel] == this.value[0])
                    // console.log(option);
                    text = this.value.length == 1 
                        ? option ? option.name : '' 
                        : this.value.length + ' selected';
                }
            }
            return text;
        },

        /** */
        unique_id(){
            return this.makeid(5);
        },

        /** */
        classlist(){
            let list = [];
            if(!this.value || this.value.length){
                list.push('is-empty');
            }
            list.push('custom-dropdown-btn-' + this.unique_id);
            return list;
        }
    },
    mounted()
    {
        this.$root.$on('windowclick', (event) => {
            if(event.target.matches('.custom-dropdown-btn-' + this.unique_id))
            {
                this.toggle();
            }
            else
            {
                if(!event.target.matches('.ms_search') && !event.target.matches('.ms_option')){
                    this.close();
                }
            }
        })
    },
    methods: {
        /**
         * close dropdown
         */
        close(event)
        {
            this.visible = false;
            this.search_word = '';
        },

        /**
         * 
         */
        toggle()
        {
            this.visible = !this.visible;
            this.search_word = '';
        },

        /**
         * string match
         */
        filter_string(string)
        {
            var match = true;
            if(this.search_word && this.searchable){
                var re = new RegExp(this.search_word, 'i');
                match = string.match(re) ? true : false;
            }
            return match;
        },

        /**
         * 
         */
        select_option(index){
            var option = this.options.find((o,i) => i == index);
            if(!this.multiple){
                this.value = this.value == option[this.valueLabel] ? null : option[this.valueLabel];
            }else{
                var check = this.value.indexOf(option[this.valueLabel]);
                if(check > -1){
                    this.value.splice(check, 1);
                }else{
                    if((this.selectLimit == null) || (this.value.length < this.selectLimit)){
                        this.value.push(option[this.valueLabel]);
                    }
                }
            }
            // 
            this.$emit('input', this.value);
        },

        /**
         * 
         */
        makeid(length) 
        {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    }
}
</script>

<style>

</style>