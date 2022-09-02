<template>
    <div class="modal fade" :id="id">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <template v-if="iconHtml">
                        <div v-html="iconHtml" :class="[`text-${variant}`]">
                        </div>
                    </template>
                    <template v-else>
                        <template v-if="icon == 'trash'">
                            <svg xmlns="http://www.w3.org/2000/svg" :class="['icon mb-2 icon-lg',`text-${variant}`]" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                        </template>
                        <template v-else-if="icon == 'alert'">
                            <svg xmlns="http://www.w3.org/2000/svg" :class="['icon mb-2 icon-lg',`text-${variant}`]" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                        </template>
                        <template v-else-if="icon == 'info'">
                            <svg xmlns="http://www.w3.org/2000/svg" :class="['icon mb-2 icon-lg',`text-${variant}`]" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>            </template>
                        <template v-else>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="['icon mb-2 icon-lg',`text-${variant}`]" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><path d="M9 12l2 2l4 -4"></path></svg>
                        </template>
                    </template>
                    
                    <h3 v-html="title"></h3>
                    <div class="text-muted" v-html="text"></div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                    <div class="row">
                        <div class="col-6">
                            <button href="#" class="btn w-100" @click.prevent="cancelHandler" v-html="cancelButtonText"></button>
                        </div>
                        <div class="col-6">
                            <button href="#" :class="['btn',`btn-${variant}`,'w-100']" @click.prevent="confirmHandler" v-html="confirmText"></button>
                        </div>
                    </div>
                    </div>
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
            default: 'AlertModal'
        },
        title: {
            type: String,
            default: 'Are you sure ?',
        },
        text: {
            type: String,
            default: '',
        },
        icon:{
            type: String,
            default: '',
        },
        iconHtml: String,
        variant:{
            type: String,
            default: 'primary',
        },

        confirmText: {
            type: String,
            default: 'Confirm'
        },
        confirmColor: {
            type: String,
            default: 'primary'
        },
        onConfirm: Function,

        cancelButtonText: {
            type: String,
            default: 'Cancel'
        },
        cancelButtonColor: String,
        hideCancelButton: Boolean,
        onCancel: Function,
    },
    data(){
        return{
            wrapper: null,
        }
    },
    computed:{

    },
    methods:{

        init(){
            this.wrapper = new Modal(document.getElementById(this.id), {});
             var $ = require('jquery');
            $('#'+this.id).on('hidden.bs.modal', (event) => {
                this.$alert.hide();
            })
        },

        // Modal Controller
        show(){
            this.wrapper.show()
        },
        hide(){
            this.wrapper.hide()
        },

        // Action Button
        async confirmHandler(){
            if(this.onConfirm){
                await this.onConfirm();
            }
            this.hide();
        },

        async cancelHandler(){
            if(this.onCancel){
                await this.onCancel();
            }
            this.hide();
        }
    },
    mounted(){
        this.init();
    },
}
</script>
<style lang="scss" scoped>
@import './styles/style.scss';
</style>