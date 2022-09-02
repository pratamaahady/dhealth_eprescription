<template>
    <div class="form-group mb-0">
        <label :class="labelClassDefault" v-html="label" v-if="label"></label>
        <div class="form-group-custom">
            <span class="prefix-label" v-if="prefix">{{ prefix }}</span>
            <input :type="!showPassword ? type : 'text'" :step="step" :min="min" :max="max" :class="inputClassDefault" v-model="userInput" :placeholder="placeholder" :autofocus="autofocus" :required="required" :disabled="disabled" ref="inputField"/>
            <div class="show-password" @click.prevent="showPasswordHandler" v-if="isPasswordType">
                <template v-if="!showPassword">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                </template>
                <template v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                    </svg>
                </template>
            </div>
        </div>
        <span class="invalid-feedback" v-html="invalidMessage"></span>
    </div>
</template>
<script>
export default {
    props:{
        type: {
            type: String,
            default: 'text'
        },
        inputClass: String,
        label: String,
        placeholder: String,
        required: Boolean,
        value: String|Number,
        min: Number,
        max: Number,
        autofocus: Boolean,
        disabled: Boolean,
        currency: Boolean,
        prefix: String,
        currencyLocale: {
            type: String,
            default: 'id',
        },
        currencyFormat: {
            type: String,
            default: 'IDR'
        },
        phoneNumber: Boolean,
        step: String,
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
                ...inputClass,
                (this.disabled) ? 'disabled' : '',
                (this.prefix) ? 'with-prefix' : ''
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

        _validatePhoneNumber(){
            if(this.phoneNumber){
                var format = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
                if(! this.userInput.match(format)){
                    this.invalidMessage = "Incorrect phone number format.";
                    return false;
                }
            }
            return true;
        },
        validationHandler(){
            if(! this._validateRequired()){
                return false
            }
            if(! this._validatePhoneNumber()){
                return false;
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
        currencyInput(){
            /* Dengan Rupiah */
            var dengan_rupiah = this.$refs.inputField;
            dengan_rupiah.addEventListener('keyup', function(e)
            {
                dengan_rupiah.value = formatRupiah(this.value);
            });

            /* Fungsi */
            function formatRupiah(angka, prefix)
            {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split    = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi),
                    separator = '';

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            }
        },
        toCurrency(number, prefix){
            if(number){
                var number_string = number.toString().replace(/[^,\d]/g, '').toString(),
                    split    = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi),
                    separator = '';

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            }
            return number;
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
        if(this.currency){
            this.currencyInput();
            this.userInput = this.toCurrency(this.value);
        }else{
            this.userInput = this.value;
        }
    }
}
</script>
<style lang="scss" scoped>

    .form-group-custom{
        display: flex;
        align-items: center;
        justify-content: center;
        position:relative;

        .show-password{
            position: absolute;
            right: 15px;
            cursor: pointer;
        }

        .form-control{
            &.is-invalid ~ .show-password{
                right: 30px;
            }

            &.with-prefix{
                padding-left: 3rem;
            }
        }

        .prefix-label{
            font-weight: bold;
            position: absolute;
            left:1rem;
        }

    }
</style>

