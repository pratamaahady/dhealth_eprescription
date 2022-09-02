<template>
    <div class="form-group mb-2">
        <label :class="labelClassDefault" v-html="label" v-if="label"></label>

        <div class="image">
            <template v-if="previewImage">
                <div class="image-preview">
                    <img :src="previewImage" />
                </div>
                <div class="image-clearable clickable" @click.prevent="clearHandler">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </div>
            </template>
            <template v-else-if="preview">
                <div class="image-preview">
                    <img :src="preview" />
                </div>
                <div class="image-clearable clickable" @click.prevent="clearHandler">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </div>
            </template>
            <template v-else>
                <div class="image-default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z"/>
                    </svg>
                </div>
            </template>
        </div>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" @change="changeFileHandler">
                <label class="custom-file-label">Choose file</label>
            </div>
        </div>
        <span class="invalid-feedback" v-html="invalidMessage"></span>
    </div>
</template>
<script>
export default {
    props:{
        inputClass: String,
        label: String,
        required: Boolean,
        preview: String|File,
        height: Number,
        width: Number,
    },
    data(){
        return{
            userInput: null,
            previewImage: this.default ?? null,
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
        clearInvalid(){
            this.invalidMessage = null;
        },
        changeFileHandler(el){
            if(el.target.files.length > 0){
                this.userInput = el.target.files[0];
                this.previewImage = URL.createObjectURL(this.userInput)
            }
        },
        clearHandler(){
            this.userInput = null;
            this.previewImage = null;
            this.$emit('input', null);
        }
    },
    watch:{
        userInput(val){
            this.$emit('input', val);
        },
    },
}
</script>
<style lang="scss" scoped>
    .image{
        display: flex;
        align-items: center;
        height: 200px;
        
        .image-clearable{
            padding: 0 20px;
            svg{
                height: 30px;
                width: 30px;
            }
        }

        .image-preview{
            width: 100%;
            overflow: hidden;

            img{
                max-height: 80%;
            }
        }

        .image-default{
            border:1px solid rgba(0,0,0,.2 );
            border-radius: 10px;
            height: 140px;
            width: 100%;
            max-height: 80%;
            max-width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;

            svg{
                height: 50px;
                width: 50px;
                
            }
        }
    }
</style>