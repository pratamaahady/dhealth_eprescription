<template>
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-header d-flex">
                <div class="ml-auto">
                    <button class="btn btn-sm btn-danger" @click.prevent="cancelHandler">
                        <i class="fas fa-arrow-left mr-2"></i> Keluar
                    </button>
                    <button class="btn btn-sm btn-info" @click.prevent="$form.submit(id)">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <FormField :onSubmit="submitHandler" :id="id">
                    <InputField name="nama_pasien" label="Nama Pasien" v-model="params.nama_pasien" :value="params.nama_pasien" class="mb-5" required/>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="m-0">Daftar Obat</h4>
                        <div class="text-center">
                            <button class="btn btn-sm btn-secondary mr-2" @click.prevent="obatFormHandler">
                                <i class="fas fa-plus mr-1"></i> Tambah Obat
                            </button>
                            <button class="btn btn-sm btn-secondary" @click.prevent="obatRacikanFormHandler">
                                <i class="fas fa-plus mr-1"></i> Tambah Obat Racikan
                            </button>
                        </div>
                    </div>
                    <Table
                        :id="table.id"
                        :headers="table.headers"
                        :columns="table.columns"
                        :datas="table.data"
                        hideCheckbox
                        hideHeader
                        hideCard
                        hideFooter
                        :sortable="false">
                        <template #3="{row}">
                            <button class="btn btn-sm btn-success mr-2" @click.prevent="editHandler(row.param, row.paramIndex)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click.prevent="removeHandler(row.param, row.paramIndex)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </template>
                    </Table>
                </FormField>
            </div>
        </div>

        <ObatFormModal :submit="addObatHandler" ref="obatFormModal"/>
        <ObatRacikanFormModal :submit="addObatRacikanHandler" ref="obatRacikanFormModal"/>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import ObatFormModal from './widgets/ObatFormModal.vue'
import ObatRacikanFormModal from './widgets/ObatRacikanFormModal.vue'
export default {
    components:{ ObatFormModal, ObatRacikanFormModal },
    props:{
        onFinish: Function,
    },
    data(){
        return{
            id: 'ObatFormID',
            title: 'Obat Form',
            params:{
                id: this.$route.params.id ?? null,
                nama_pasien: null,
                obatalkes: [],
                obatalkes_racikan: [],
            },
            table:{
                id: 'ResepTableId',
                headers: ['Nama Obat','Signa','Jumlah',''],
                columns: [
                    { data: 'nama_obat' },
                    { data: 'signa.signa_nama' },
                    { data: 'quantity' },
                    { data: 'paramIndex', class: 'cell-fit-content' },
                ],
                data: [],
            }
        }
    },
    computed:{
        ...mapGetters('resep',['resep']),
        payload(){
            return {
                nama_pasien: this.params.nama_pasien,
                obatalkes: this.params.obatalkes.map(function(item){
                    return {
                        id: item.obat.obatalkes_id,
                        signa_id: item.signa.signa_id,
                        quantity: item.quantity
                    }
                }),
                obatalkes_racikan: this.params.obatalkes_racikan.map(function(item){
                    return {
                        nama: item.nama,
                        signa_id: item.signa.signa_id,
                        quantity: item.quantity,
                        obatalkes: [
                            ...item.obats.map(function(obat){
                                return {
                                    id: obat.obat.obatalkes_id,
                                    quantity: obat.quantity
                                }
                            }),
                        ]
                    }
                }),
            }
        }
    },
    methods:{
        ...mapActions('resep',['loadResep','createResep','updateResep']),

        fetchDataHandler(){
            if(this.params.id){
                // return this.loadResep(this.params.id).then(() => {
                //     this.params = {
                //         id: this.obat.obatalkes_id,
                //         obatalkes_kode: this.obat.obatalkes_kode,
                //         obatalkes_nama: this.obat.obatalkes_nama,
                //     };
                // });
            }
        },

        obatFormHandler(){
            this.$refs.obatFormModal.create();
        },
        addObatHandler(data, index){
            if(index != null){
                this.params.obatalkes[index] = {
                    obat: data.obat,
                    signa: data.signa,
                    quantity: data.quantity,
                };
            }else{
                this.params.obatalkes.push({
                    obat: data.obat,
                    signa: data.signa,
                    quantity: data.quantity,
                });
            }
            this.reloadTable();
        },
        editObatHandler(index){
            this.$refs.obatFormModal.edit(this.params.obatalkes[index],index);
        },

        obatRacikanFormHandler(){
            this.$refs.obatRacikanFormModal.create();
        },
        addObatRacikanHandler(data, index){
            if(index != null){
                this.params.obatalkes_racikan[index] = {
                    nama: data.nama,
                    signa: data.signa,
                    quantity: data.quantity,
                    obats: data.obats
                };
            }else{
                this.params.obatalkes_racikan.push({
                    nama: data.nama,
                    signa: data.signa,
                    quantity: data.quantity,
                    obats: data.obats
                });
            }
            this.reloadTable();
        },
        editObatRacikanHandler(index){
            this.$refs.obatRacikanFormModal.edit(this.params.obatalkes_racikan[index]);
        },

        editHandler(varName, varIndex){
            switch(varName){
                case 'obatalkes':
                    this.editObatHandler(varIndex);
                    break;
                case 'obatalkes_racikan':
                    this.editObatRacikanHandler(varIndex);
                    break;
                default :
            }
        },
        removeHandler(varName, varIndex){
            this.params[varName].splice(varIndex, 1);
        },

        submitHandler(){
            if(! this.params.id){
                var action = this.createResep(this.payload);
            }else{
                var action = this.updateResep({ id: this.params.id, params: this.payload });
            }

            action
                .then(resp => {
                    this.$toast.success(resp.message);
                    this.$router.push({ name: 'resep' })
                })
                .catch(err => {
                    this.$form.setError(this.id, err.message)
                })
        },

        cancelHandler(){
            this.$router.push({ name: 'resep' });
        },

        reloadTable(){
            this.table.data = [
                ...this.params.obatalkes.map(function(item,itemIndex){
                    return {
                        nama_obat: item.obat.obatalkes_nama,
                        quantity: item.quantity,
                        signa: item.signa,
                        param: 'obatalkes',
                        paramIndex: itemIndex,
                    }
                }),
                ...this.params.obatalkes_racikan.map(function(item, itemIndex){
                    return {
                        nama_obat: item.nama,
                        quantity: item.quantity,
                        signa: item.signa,
                        param: 'obatalkes_racikan',
                        paramIndex: itemIndex,
                    }
                }),
            ];
        }
    },
    mounted(){
        this.$loader.show();
        Promise.all([
            this.fetchDataHandler(),
        ])
        .then(resp => {
            this.$loader.hide();
        })
    }
}
</script>
