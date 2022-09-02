<template>
    <form @submit.prevent="submitHandler" class="input-group-search justify-content-start">
        <div class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20" viewBox="0 0 25 25" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
        </div>
        <div class="search-input w-100">
            <input
                type="text"
                class="w-100"
                :placeholder="placeholder"
                v-model="userInput"
                @blur="submitHandler"
            />
        </div>
    </form>
</template>
<script>
/* Scss */

/*  */
export default {
    name: 'TableSearch',
    props:{
        onSubmit: Function,
        placeholder: {
            type: String,
            default: "Search"
        }
    },
    data(){
        return {
            userInput: null,
        }
    },
    methods:{
        submitHandler: function(){
            if(this.$attrs.value != this.userInput){
                this.$emit('input', this.userInput);
                this.$forceUpdate();
                if(this.onSubmit){
                    this.onSubmit();
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
form.input-group-search{
    border:1px solid rgba(0,0,0,.2);
    display:flex;
    align-items: center;
    justify-content: center;
    margin-block-end: auto;
    padding: 3px 10px;
    border-radius: 5px;
    height: 100%;
    
    .search-icon{
        color: rgba(0,0,0,.4);
    }
    .search-input{
        margin-left: 5px;

        input{
            border: none;
            outline: none;
            // border-radius: 10px 0 0 10px;
            color: rgba(0,0,0,.7);
            padding:5px 0;
            font-size: 13px;
        }
    }
}
</style>
