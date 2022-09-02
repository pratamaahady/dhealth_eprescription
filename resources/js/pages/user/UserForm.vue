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
                    <InputField name="name" label="Nama Lengkap" v-model="parameters.name" :value="parameters.name" class="mb-4" required/>
                    <InputField name="username" label="Username" :value="parameters.username" class="mb-4" disabled v-if="parameters.id != null"/>
                    <InputField name="username" label="Username" v-model="parameters.username" :value="parameters.username" class="mb-4" required v-else/>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-6">
                            <InputField type="password" name="password" label="Kata Sandi ( opsional )" v-model="parameters.password" :value="parameters.password" :required="parameters.id == null"/>
                        </div>
                        <div class="col-12 col-lg-6">
                            <InputField type="password" name="password_confirmation" label="Konfirmasi Kata Sandi ( opsional )" v-model="parameters.password_confirmation" :value="parameters.password_confirmation" :required="parameters.id == null || parameters.password != null"/>
                        </div>
                    </div>
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
            id: 'UserFormID',
            title: 'User Form',
            parameters:{
                id: this.$route.params.id ?? null,
                name: null,
                username: null,
                password: null,
                password_confirmation: null,
            },
        }
    },
    computed:{
        ...mapGetters('user',['user']),
    },
    methods:{
        ...mapActions('user',['loadUser','createUser','updateUser']),

        fetchDataHandler(){
            if(this.parameters.id){
                return this.loadUser(this.parameters.id).then(() => {
                    this.parameters = {
                        id: this.user.id,
                        name: this.user.name,
                        username: this.user.username,
                    };
                });
            }
        },

        submitHandler(){
            if(! this.parameters.id){
                var action = this.createUser(this.parameters);
            }else{
                var action = this.updateUser({ id: this.parameters.id, params: this.parameters });
            }

            action
                .then(resp => {
                    this.$toast.success(resp.message);
                    this.$router.push({ name: 'user' })
                })
                .catch(err => {
                    this.$form.setError(this.id, err.message)
                })
        },

        cancelHandler(){
            this.$router.push({ name: 'user' });
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
