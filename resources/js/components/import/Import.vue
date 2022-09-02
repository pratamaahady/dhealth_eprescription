<template>
    <BasicModal
        :id="id"
        :title="title"
        :onSubmit="() => $form.submit(id)"
        submitLabel="Import"
        :onShow="resetParams"
        closeLabel="Batal"
        submitVariant="success">
        <FormField :onSubmit="submitHandler" :id="id">
            <InputFile
                ref="ImportFile"
                name="file"
                v-model="params.file"
                required/>
        </FormField>

        <template #modal-footer>
            <div class="mr-auto">
                <button class="btn btn-sm btn-warning" @click.prevent="templateHandler">
                    <i class="fas fa-file mr-2"></i> Template
                </button>
            </div>
        </template>
    </BasicModal>
</template>
<script>
export default {
    props:{
        id:{
            type: String,
            default: 'ImportID',
        },
        title: {
            type: String,
            default: 'Import'
        },
        template: Function,
        submit: Function,
        finish: Function,
    },
    data(){
        return {
            params: {
                file: null,
            },
        }
    },
    methods:{
        show(){
            this.$modal.show(this.id)
        },
        hide(){
            this.$modal.hide(this.id)
        },
        resetParams(){
            this.$refs.ImportFile.reset();
            this.$form.clearError();
            this.params.file = null;
        },
        submitHandler(){
            if(this.submit){
                this.$loader.show();
                this.submit(this.params)
                    .then(resp => {
                        this.$modal.hide(this.id);
                        this.$toast.success(resp.message)
                        this.finishHandler(resp);
                    })
                    .catch(err => {
                        this.$toast.error(err.message)
                    })
                    .then(resp => {
                        this.$loader.hide()
                    })
            }
        },
        finishHandler(resp){
            if(this.finish){
                this.finish(resp);
            }
        },
        templateHandler(){
            if(this.template){
                this.template()
            }
        }
    },
}
</script>
