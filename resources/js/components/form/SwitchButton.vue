<template>
    <div class="toggle-switch">
        <div class="label" v-html="label" v-if="label"></div>
        <label :class="['switch', userInput ? 'switch-checked' : '']">
            <input type="checkbox" v-model="userInput"/>
            <div></div>
        </label>
    </div>
</template>
<script>
export default {
    props:{
        label: String,
        value: Boolean,
    },
    data(){
        return {
            userInput: false,
        }
    },
    watch:{
        userInput(val){
            this.$emit('input', val);
        },
        value(val){
            this.userInput = val;
        },
    },
    mounted(){
        this.userInput = this.value;
    }
}
</script>


<style lang="scss" scoped>
.toggle-switch{

    .label{
        font-size: 1rem;
        display: block;
        padding:0;
        margin-bottom: 0.5rem;
        text-align: left;
    }
    

    .switch{
        position: relative;
        display: block;
        width: 80px;
        height: 37px;
        border-radius: 37px;
        background-color: #f3f4f4;
        cursor: pointer;
        transition: all .3s;
        overflow: hidden;
        box-shadow: 0px 0px 2px rgba(0,0,0, .3);
        margin-bottom: 0;
    }
    .switch input{
        display: none;
    }
    .switch input:checked + div{
        left: calc(80px - 32px);
        box-shadow: 0px 0px 0px white;
    }

    .switch div{
        position: absolute;
        width: 27px;
        height: 27px;
        border-radius: 27px;
        background-color: white;
        top: 5px;
        left: 5px;
        box-shadow: 0px 0px 1px rgb(150,150,150);
        transition: all .3s;
    }
    .switch div:before, .switch div:after{
        position: absolute;
        content: '';
        width: calc(80px - 40px);
        height: 37px;
        line-height: 37px;
        font-family: 'Varela Round';
        font-size: 14px;
        font-weight: bold;
        top: -5px;
    }
    .switch div:before{
        content: '';
        color: rgb(120,120,120);
        left: 100%;
    }
    .switch div:after{
        content: '';
        right: 100%;
        color: white;
    }

    .switch-checked{
        background-color : #e74c3c;
        box-shadow: none;
    }
}
</style>