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
                    <InputField name="obatalkes_kode" label="Kode Obat" v-model="parameters.obatalkes_kode" :value="parameters.obatalkes_kode" class="mb-4" required/>
                    <InputField name="obatalkes_nama" label="Nama Obat" v-model="parameters.obatalkes_nama" :value="parameters.obatalkes_nama" class="mb-4" required/>
                </FormField>

            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    props:{
        onFinish: Function,
    },
    data(){
        return{
            id: 'ObatFormID',
            title: 'Obat Form',
            parameters:{
                id: this.$route.params.id ?? null,
                obatalkes_kode: null,
                obatalkes_nama: null,
            },
        }
    },
    computed:{
        ...mapGetters('obat',['obat']),
    },
    methods:{
        ...mapActions('obat',['loadObat','createObat','updateObat']),

        fetchDataHandler(){
            if(this.parameters.id){
                return this.loadObat(this.parameters.id).then(() => {
                    this.parameters = {
                        id: this.obat.obatalkes_id,
                        obatalkes_kode: this.obat.obatalkes_kode,
                        obatalkes_nama: this.obat.obatalkes_nama,
                    };
                });
            }
        },

        submitHandler(){
            if(! this.parameters.id){
                var action = this.createObat(this.parameters);
            }else{
                var action = this.updateObat({ id: this.parameters.id, params: this.parameters });
            }

            action
                .then(resp => {
                    this.$toast.success(resp.message);
                    this.$router.push({ name: 'obat' })
                })
                .catch(err => {
                    this.$form.setError(this.id, err.message)
                })
        },

        cancelHandler(){
            this.$router.push({ name: 'obat' });
        },
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
