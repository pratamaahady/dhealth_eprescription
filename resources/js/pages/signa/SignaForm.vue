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
                    <InputField name="signa_kode" label="Kode Signa" v-model="parameters.signa_kode" :value="parameters.signa_kode" class="mb-4" required/>
                    <InputField name="signa_nama" label="Nama Signa" v-model="parameters.signa_nama" :value="parameters.signa_nama" class="mb-4" required/>
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
            id: 'SignaFormID',
            title: 'Signa Form',
            parameters:{
                id: this.$route.params.id ?? null,
                signa_kode: null,
                signa_nama: null,
            },
        }
    },
    computed:{
        ...mapGetters('signa',['signa']),
    },
    methods:{
        ...mapActions('signa',['loadSigna','createSigna','updateSigna']),

        fetchDataHandler(){
            if(this.parameters.id){
                return this.loadSigna(this.parameters.id).then(() => {
                    this.parameters = {
                        id: this.signa.signa_id,
                        signa_kode: this.signa.signa_kode,
                        signa_nama: this.signa.signa_nama,
                    };
                });
            }
        },

        submitHandler(){
            if(! this.parameters.id){
                var action = this.createSigna(this.parameters);
            }else{
                var action = this.updateSigna({ id: this.parameters.id, params: this.parameters });
            }

            action
                .then(resp => {
                    this.$toast.success(resp.message);
                    this.$router.push({ name: 'signa' })
                })
                .catch(err => {
                    this.$form.setError(this.id, err.message)
                })
        },

        cancelHandler(){
            this.$router.push({ name: 'signa' });
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
