<template>
    <div class="d-flex align-items-center text-muted">
        Show
            <div class="mx-2 d-inline-block">
            <div class="basic-dropdown">
                <div class="dropdown dropdown-dark dropup">
                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle px-3 py-1" data-toggle="dropdown">
                        {{ user_input }}
                    </button>
                    <div class="dropdown-menu">
                        <a v-for="(option,index) in options" :key="index" @click.prevent="changeUserInput(option)"
                            :class="['dropdown-item', (option == user_input) ? 'active' : '']"
                            href="javascript:;">
                            {{ option }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        of {{ total }} entries
    </div>
</template>
<script>
export default {
    props:{
        meta: Object,
        total: {
            type: Number,
            default: 0,
        },
        value: {
            type: Number,
            default: 10,
        },
    },
    data(){
        return{
            user_input: this.value,
            options:[this.value, 25, 50, 100],
        }
    },
    watch:{
        user_input: function(val){
            this.$emit('input', val);
        }
    },
    methods:{
        changeUserInput(val){
            this.user_input = val;
        }
    }
}
</script>