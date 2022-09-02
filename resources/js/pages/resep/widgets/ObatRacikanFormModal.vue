<template>
    <BasicModal :id="id" submitLabel="Tambah" closeLabel="Batal" title="Tambah Obat Racikan" :onSubmit="() => $form.submit(id)">
        <FormField :id="id" :onSubmit="submitHandler">
            <InputField
                class="mb-4"
                name="obatalkes_racikan_nama"
                label="Nama Obat Racikan"
                v-model="params.nama"
                :value="params.nama"
                required/>

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

            <InputField
                class="mb-5"
                name="jumlah"
                label="Jumlah"
                type="number"
                v-model="params.quantity"
                :value="params.quantity"
                required/>


                <h4 class="mb-2">Komposisi</h4>

                <table class="table w-100">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(obat, obatIndex) in params.obats" :key="obatIndex">
                            <td width="60%">
                                <InputSelect
                                    name="obatalkes_nama"
                                    :options="obats"
                                    :inputReduce="opt => opt"
                                    inputLabel="obatalkes_nama"
                                    v-model="obat.obat"
                                    :value="obat.obat"
                                    :clearable="false"
                                    required/>
                            </td>
                            <td width="15%">
                                <InputField :value="obat.obat ? obat.obat.stok : '-'"  disabled/>
                            </td>
                            <td width="15%">
                                <InputField
                                    name="jumlah"
                                    type="number"
                                    :min="1"
                                    :max="obat.obat ? obat.obat.stok : null"
                                    v-model="obat.quantity"
                                    :value="obat.quantity"
                                    required/>
                            </td>
                            <td class="cell-fit-content text-right">
                                <button class="btn btn-sm btn-danger" @click.prevent="removeHandler(obatIndex)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">
                                <button class="btn btn-sm btn-secondary" @click.prevent="addHandler"> Tambah </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            id: 'obatRacikanFormModalId',
            index: null,
            params:{
                nama: null,
                signa: null,
                quantity: null,
                obats: [],
            },
            table: {
                id: 'ObatRacikanObatTableId',
                headers:['Nama Obat','Jumlah','Stok',''],
                columns:[
                    { data: 'obat.obatalkes_nama'},
                    { data: 'quantity', class: 'w-25' },
                    { data: 'obat.obatalkes_id', class: 'cell-fit-content' },
                ]
            }
        }
    },
    computed:{
        ...mapGetters('obat',['obats']),
        ...mapGetters('signa',['signas']),
    },
    methods:{
        ...mapActions('obat',['loadObats']),
        ...mapActions('signa',['loadSignas']),
        resetParams(){
            this.index = null;
            this.params.nama = null;
            this.params.obats = [];
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
            this.params.nama = data.nama;
            this.params.obats = data.obats;
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

        addHandler(){
            this.params.obats.push({
                obat: null,
                quantity: 0,
            })
        },
        removeHandler(index){
            this.params.obats.splice(index,1);
        },
        submitHandler(){
            if(this.submit){
                this.submit(this.params, this.index);
            }
            this.hide();
        },
    },
    mounted(){
    }
}
</script>
