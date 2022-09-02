<template>
    <div class="modal fade" :id="id">
        <div :class="['modal-dialog', `modal-${size}`]" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-html="title"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div :class="['modal-body', bodyClass]">
                    <slot />
                </div>
                <div class="modal-footer" v-if="!hideFooter">
                    <slot name="modal-footer"></slot>
                    <button type="button" class="btn btn-secondary light btn-sm" data-dismiss="modal" v-html="closeLabel" v-if="!hideClose"></button>
                    <button type="button" :class="['btn',`btn-${submitVariant}`, `btn-sm`]" @click.prevent="submitHandler" v-html="submitLabel" v-if="!hideSubmit"></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Modal } from 'bootstrap'
export default {
    props:{
        id: {
            type: String,
            required: true,
        },
        submitLabel: {
            type: String,
            default: 'Confirm'
        },
        submitVariant:{
            type: String,
            default: 'primary'
        },
        closeLabel: {
            type: String,
            default: 'Close'
        },
        title: {
            type: String,
            default: 'Modal Title',
        },
        size:{
            type: String,
            default: 'lg',
        },
        bodyClass: String,
        onSubmit: Function,
        hideFooter: Boolean,
        hideSubmit: Boolean,
        hideClose: Boolean,
        onShow: Function,
    },
    data(){
        return{
            wrapper: null,
        }
    },
    methods:{
        async submitHandler(){
            if(this.onSubmit){
                await this.onSubmit();
            }
        },
        init(){
            this.wrapper = new Modal(document.getElementById(this.id));
        },
        show(){
            if(this.onShow) this.onShow()
            this.wrapper.show()
        },
        hide(){
            this.wrapper.hide()
        },
    },
    mounted(){
        document.body.appendChild(this.$el)
        this.init();
    },
    created(){
        this.$modal.components.push(this);
    },
    destroyed(){
        const index = this.$modal.components.findIndex((component) => component.id === this.id);
        if(index !== -1){
            this.$el.remove();
            this.$modal.components.splice(index, 1);
        }
    }
}
</script>
<style lang="scss" scoped>
@import "./styles/style.scss";
</style>
