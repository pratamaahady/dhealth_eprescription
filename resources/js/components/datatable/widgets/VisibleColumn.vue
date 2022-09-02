<template>
    <div class="basic-dropdown">
        <div class="dropdown dropdown-dark">
            <button type="button" class="btn btn-sm btn-dark dropdown-toggle px-2 py-2" data-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-columns-gap mr-1" viewBox="0 0 16 16">
                    <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
                </svg>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-item" v-for="(option, optionIndex) in options" :key="optionIndex" @click.prevent="clickHandler($event, optionIndex)">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" checked>
                        <label class="custom-control-label" for="customCheckBox1">{{ option }}</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        options: {
            type: Array,
            required: true,
        },
    },
    data(){
        return{
            visibles:[],
        }
    },
    methods:{
        clickHandler(e, optionIndex){
            e.stopPropagation();

            var parentEl = e.target.closest('li');
            var inputEl = parentEl.querySelector('input[type="checkbox"]');
            var index = this.visibles.indexOf(optionIndex);

            inputEl.checked = !inputEl.checked;
            if(inputEl.checked){
                this.visibles.push(optionIndex);
            }else{
                this.visibles.splice(index, 1);
            }
        },

    },
    watch:{
        visibles(val){
            this.$emit('input', val);
        }
    },
    mounted(){
        this.options.forEach((option, index) => {
            this.visibles.push(index);
        })
    }
}
</script>