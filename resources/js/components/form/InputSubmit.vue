<template>
    <button type="submit" class="btn btn-primary w-100" :disabled="! isAway">
        <slot />
    </button>
</template>
<script>
export default {
    computed:{
        isAway(){
            return this.$parent.isAway != undefined ? this.$parent.isAway : true;
        }
    }
}
</script>