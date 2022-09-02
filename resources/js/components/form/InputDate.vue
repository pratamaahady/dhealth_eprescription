<template>
    <div class="form-group mb-0">
        <label :class="labelClassDefault" v-html="label" v-if="label"></label>
        <VueDatePicker
            v-model="userInput"
            format-header="dddd, DD MMMM"
            :min-date="minDate"
            :max-date="maxDate"
            :placeholder="placeholder"
            :class="inputClassDefault"
            :required="required"
            :disabled="disabled" />

        <span class="invalid-feedback" v-html="invalidMessage"></span>
    </div>
</template>
<script>
import { VueDatePicker } from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

export default {
    components:{
        VueDatePicker,
    },
    props:{
        value: String|Date,
        minDate: String|Date,
        maxDate: String|Date,
        inputClass: String,
        label: String,
        placeholder: String,
        required: Boolean,
        disabled: Boolean,
    },
    data(){
        return{
            userInput: null,
            invalidMessage: null,
        }
    },
    computed:{
        invalidClassDefault(){
            return this.invalidMessage ? 'is-invalid' : '';
        },
        inputClassDefault(){
            var inputClass = this.inputClass ? this.inputClass.split(" ") : [];
            return [
                'form-control',
                'd-flex',
                'align-items-center',
                this.invalidClassDefault,
                ...inputClass
            ];
        },
        labelClassDefault(){
            var classes = ['form-label'];
            if(this.required){
                classes.push('required');
            }
            return classes;
        },
    },
    methods:{
        _validateRequired(){
            if(this.required){
                if(!this.userInput || this.userInput == ""){
                    this.invalidMessage = "This field is required.";
                    return false;
                }
            }
            return true;
        },
        validationHandler(){
            if(! this._validateRequired()){
                return false
            }

            this.invalidMessage = null;
            return true;
        },
        clearInvalid(){
            this.invalidMessage = null;
        },
    },
    watch:{
        userInput(val){
            this.$emit('input', val);
        },
        value(val){
            this.userInput = val;
        }
    },
    mounted(){
        this.userInput = this.value;
    }
}
</script>
