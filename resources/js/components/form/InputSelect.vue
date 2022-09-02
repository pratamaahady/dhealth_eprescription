<template>
    <div class="form-group mb-0">
        <label :class="labelClassDefault" v-html="label" v-if="label"></label>
        <v-select
            v-model="userInput"
            :label="inputLabel"
            :class="inputClassDefault"
            :options="options"
            :reduce="inputReduce"
            :placeholder="placeholder"
            :multiple="multiple"
            :required="required"
            :clearable="clearable"
            :disabled="disabled"
            @search="search">
            <template #option="option">
                <slot name="option" v-bind="option"></slot>
            </template>
            <template #selected-option="option">
                <slot name="selected-option" v-bind="option"></slot>
            </template>
            <template slot="no-options">
                <slot name="no-options"></slot>
            </template>
        </v-select>
        <span class="invalid-feedback" v-html="invalidMessage"></span>
    </div>
</template>
<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
    components:{
        vSelect,
    },
    props:{
        inputClass: String,
        label: String,
        placeholder: String,
        required: Boolean,
        inputLabel: String,
        inputReduce: Function,
        options: Array,
        value: Number|String|Object|Array,
        multiple: Boolean,
        clearable: {
            type: Boolean,
            default: true
        },
        disabled: Boolean,
        search: {
            type: Function,
            default: () => {}
        },
    },
    data(){
        return{
            userInput: null,
            showPassword: false,
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
                'p-0',
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
        isPasswordType(){
            return (this.type == 'password');
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
<style lang="scss">
.v-select.form-control{
    &.is-invalid{
        padding-right: 15px !important;
    }

    .vs__dropdown-toggle{
        border: none !important;
        height: 100%;
    }

    .vs__search::placeholder{
        color: rgb(131, 131, 131) !important;
    }

    .vs__actions{
        margin-right: 10px;
    }
}
</style>
