<template>
    <div class="form-group">
        <label v-if="label" v-html="label"></label>
        <div class="file-upload-wrapper text-secondary">
            <div class="file-upload-ui">
                <template v-if="userInput">
                    <i class="fas fa-file"></i>
                    <span class="text-drag-drop" v-html="userInput.name"></span>
                </template>
                <template v-else>
                    <i class="fas fa-folder"></i>
                    <span class="text-drag-drop">Drag & Drop your file here</span>
                </template>
            </div>
            <input name="file-upload-field" type="file" class="file-upload-field" @change="onChangeHandler" ref="InputFile">
        </div>
        <div class="text-danger text-sm" v-if="error">{{ error }}</div>
    </div>
</template>
<script>
export default {
    props:{
        label: String,
        addClass: String,
        name:String,
        required: Boolean,
        disabled: Boolean,
        placeholder: String,
    },
    data(){
        return{
            userInput: null,
        }
    },
    watch:{
        userInput: function(val){
            this.$emit('input',val);
        }
    },
    computed:{
        inputClass: function(){
            const addClass = this.addClass ? this.addClass.split(" ") : [];
            if(this.error){
                addClass.push('is-invalid');
            }

            return [
                "form-control",
                ...addClass,
            ];
        },
        error: function(){
            var errors = null;
            if(this.$parent.formError){
                errors = _.chain(this.$parent.formError.errors).find((item,key) => key == this.name).join(',').value();
            }
            return errors;
        },
    },
    methods:{
        onChangeHandler: function(e){
            if(e.target.files.length > 0){
                this.userInput = e.target.files[0]
            }else{
                this.reset();
            }
        },
        reset: function(){
            this.userInput = null;
            this.$refs.InputFile.value = '';
        }
    },
}
</script>
<style lang="scss" scoped>
    .file-upload-wrapper{
        border:1px dashed;
        padding:20px;
        position: relative;
        border-radius: 20px;
        cursor: pointer;

        .file-upload-field{
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-ui{
            width: 100%;
            // height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

            i{ font-size: 40px; }
            .text-drag-drop{
                font-size: 15px;
                font-weight: bold;
            }
        }
    }
</style>
