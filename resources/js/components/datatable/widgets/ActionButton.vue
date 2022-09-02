<template>
    <a :class="['dropdown-item px-2', disabledClass]" href="javascript:;" :disabled="this.disabled">
        <template v-if="isEdit">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line>
            </svg>
            <span class="ml-2">Edit</span>
        </template>
        <template v-else-if="isDelete">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="7" x2="20" y2="7"></line>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
            </svg>
            <span class="ml-2">Delete</span>
        </template>
        <template v-else>
            <slot name="icon" />
            <span :class="[hasIcon ? 'ml-2' : '']" v-html="label"></span>
        </template>
    </a>
</template>
<script>
export default {
    props:{
        label: String,
        isEdit: Boolean,
        isDelete: Boolean,
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    computed:{
        hasIcon(){
            return !!this.$slots.icon;
        },
        disabledClass(){
            return this.disabled ? 'disabled' : '';
        }
    },
}
</script>
<style lang="scss" scoped>
    .dropdown-item{
        i{
            font-size: 20px;
        }
        &.disabled, &:disabled{
            color: rgba(0,0,0,.3) !important;
        }
    }
</style>