<template>
    <div class="form-group mb-0">
        <label :class="labelClassDefault" v-html="label" v-if="label"></label>
        <textarea
            :class="inputClassDefault"
            v-model="userInput"
            :placeholder="placeholder"
            :required="required"
            :rows="rows"
            @blur="blurHandler"
            ref="inputField"
            :id="id"
            :disabled="disabled">
        </textarea>
        <span class="invalid-feedback" v-html="invalidMessage"></span>
    </div>
</template>
<script>
export default {
    props:{
        id: String,
        inputClass: String,
        label: String,
        placeholder: String,
        required: Boolean,
        value: String|Number,
        rows: {
            type: Number,
            default: 5,
        },
        disabled: Boolean,
        onBlur: Function,
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
                this.invalidClassDefault,
                ...inputClass
            ];
        },
        isPasswordType(){
            return (this.type == 'password');
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
        showPasswordHandler(){
            this.showPassword = !this.showPassword;
        },
        clearInvalid(){
            this.invalidMessage = null;
        },
        blurHandler(){
            if(this.onBlur){
                this.onBlur();
            }
        },
        focus(){
            this.$refs.inputField.focus();
        }
    },
    watch:{
        userInput(val){
            this.$emit('input', val);
        },
        value(val){
            this.userInput = val;
        }
    },
}
</script>
