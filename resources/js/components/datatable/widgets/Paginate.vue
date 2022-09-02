<template>
    <div class="_paginate">
        <button class="_paginateItem btn btn-sm btn-dark" @click.prevent="onChangePage(user_input - 1)" :disabled="!prevStatus">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button :class="['_paginateItem btn btn-sm btn-dark', user_input == page ? 'active' : '']" v-for="page in pageRange" :key="page" @click.prevent="onChangePage(page)" :disabled="!pageRangeStatus">
            {{ page }}
        </button>
        <button class="_paginateItem btn btn-sm btn-dark" @click.prevent="onChangePage(user_input - 1)" :disabled="!nextStatus">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</template>
<script>
export default{
    props:{
        "total-page":{
            type: Number,
            default: 1,
        },
        "current-page":{
            type: Number,
            default: 1,
        },
        disabled: Boolean,
    },
    data(){
        return{
            user_input: this.currentPage,
        }
    },
    computed:{
        prevStatus: function() {
            return (this.user_input == 1 && !this.disabled) ? false : true;
        },
        nextStatus: function() {
            return (this.user_input == this.totalPage && !this.disabled) ? false : true;
        },
        pageRangeStatus(){
            return !this.disabled;
        },
        pageRange: function(){
            var startLogic = this.user_input - 2;
            var start = (startLogic < 1) ? 1 : startLogic;

            var endLogic = this.user_input + 2;
            var end = (endLogic > this.totalPage) ? this.totalPage : endLogic;

            var res = [];
            for(var i=start;i<=end;i++){
                res.push(i);
            }
            return res;
        },
        currPage(){
            return this.currentPage;
        },
    },
    watch:{
        user_input: function(val){
            if(!this.disabled){
                this.$emit('input',val);
            }
        },
        currentPage(val){
            if(!this.disabled){
                this.user_input = val;
            }
        },
    },
    methods:{
        onChangePage: function(page){
            if(!this.disabled){
                if (page > this.totalPage){
                    page = this.totalPage;
                }

                if (page < 1){
                    page = 1;
                }

                this.user_input = page;
            }
        },
    },
}
</script>
<style lang="scss">
    ._paginate{
        display: flex;
        ._paginateItem{
            display: block;
            margin-left: .5rem;
        }
    }
</style>
