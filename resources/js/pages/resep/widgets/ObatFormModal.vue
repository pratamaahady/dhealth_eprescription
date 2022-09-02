<template>
    <BasicModal :id="id" submitLabel="Tambah" closeLabel="Batal" title="Tambah Obat" :onSubmit="() => $form.submit(id)">
        <FormField :id="id" :onSubmit="submitHandler">
            <InputSelect
                class="mb-4"
                name="obatalkes_nama"
                label="Obat"
                :options="obats"
                :inputReduce="obat => obat"
                inputLabel="obatalkes_nama"
                v-model="params.obat"
                :value="params.obat"
                :clearable="false"
                required/>

            <InputField class="mb-4" label="Stok" :value="stok" disabled/>

            <InputSelect
                class="mb-4"
                name="signa_nama"
                label="Signa"
                :options="signas"
                :inputReduce="signa => signa"
                inputLabel="signa_nama"
                v-model="params.signa"
                :value="params.signa"
                :clearable="false"
                required/>

            <InputField name="jumlah" label="Jumlah" type="number" :min="1" :max="stok" v-model="params.quantity" :value="params.quantity" required/>
        </FormField>
    </BasicModal>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    props:{
        submit: Function,
    },
    data(){
        return {
            id: 'obatFormModalId',
            index: null,
            params:{
                obat: null,
                signa: null,
                quantity: null
            }
        }
    },
    computed:{
        ...mapGetters('obat',['obats']),
        ...mapGetters('signa',['signas']),
        stok(){
            return this.params.obat ? this.params.obat.stok : null;
        }
    },
    methods:{
        ...mapActions('obat',['loadObats']),
        ...mapActions('signa',['loadSignas']),
        resetParams(){
            this.index = null;
            this.params.obat = null;
            this.params.signa = null;
            this.params.quantity = null;
        },
        create(){
            this.resetParams();
            this.show();
        },
        edit(data, index){
            this.resetParams();
            this.index = index;
            this.params.obat = data.obat;
            this.params.signa = data.signa;
            this.params.quantity = data.quantity;

            this.show();
        },
        show(){
            this.$loader.show();
            Promise.all([
                this.loadObats({
                    have_stock: true,
                }),
                this.loadSignas(),
            ])
            .then(resp => {
                this.$modal.show(this.id)
                this.$loader.hide();
            })
        },
        hide(){
            this.$modal.hide(this.id);
        },
        submitHandler(){
            if(this.submit){
                this.submit(this.params, this.index);
            }
            this.hide();
        },
    },
}
</script>
