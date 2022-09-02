<template>
    <div class="card card-collapse">
        <div class="card-header">
            <a data-toggle="collapse" :href="`#${id}`" :aria-expanded="`${show}`" class="d-block card-collapse-toggle">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-bold">{{ title }}</span>
                    <i class="fa fa-chevron-down pull-right"></i>
                </div>
            </a>
        </div>
        <div :id="id" :class="['collapse', show ? 'show' : '']">
            <div class="card-body">
                <slot></slot>
            </div>
            <div class="card-footer" v-if="hasSlot('footer')">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        id: {
            type: String,
            required: true,
        },
        title: String,
        show: Boolean,
    },
    methods:{
        hasSlot(slotName){
            return !!this.$slots[slotName];
        },
    },
}
</script>
<style lang="scss">
    .card-collapse{
        .card-collapse-toggle{
            text-decoration: none;
            color: inherit;
        }
    }
</style>
