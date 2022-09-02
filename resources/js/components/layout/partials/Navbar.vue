<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <h5 class="m-0">{{ $route.meta.title }}</h5>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="javascript:;">
                    <i class="far fa-user mr-2"></i> {{ user.name }}
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="javascript:;" class="dropdown-item" @click.prevent="changePasswordHandler">
                        <i class="fas fa-lock mr-2"></i> Ubah Password
                    </a>
                    <a href="javascript:;" class="dropdown-item" @click.prevent="logoutHandler">
                        <i class="fas fa-power-off mr-2"></i> Keluar
                    </a>
                </div>
            </li>
        </ul>
        <BasicModal :id="changePassword.modal.id" :onSubmit="() => $form.submit(changePassword.form.id)" :title="changePassword.modal.title" :submitLabel="changePassword.modal.submitLabel">
            <FormField :onSubmit="changePasswordSubmitHandler" :id="changePassword.form.id">
                <InputField name="old_password" label="Password Lama" type="password" v-model="changePassword.form.parameters.old_password" :value="changePassword.form.parameters.old_password" class="mb-4" required/>
                <InputField name="new_password" label="Password Baru" type="password" v-model="changePassword.form.parameters.new_password" :value="changePassword.form.parameters.new_password" class="mb-4" required/>
                <InputField name="new_password_confirmation" label="Konfirmasi Password Baru" type="password" v-model="changePassword.form.parameters.new_password_confirmation" :value="changePassword.form.parameters.new_password_confirmation" class="mb-4" required/>
            </FormField>
        </BasicModal>
    </nav>
</template>
<script>
import constants from '@/configs/constants';
import { mapActions, mapGetters } from 'vuex';

export default {
    data(){
        return{
            changePassword:{
                modal:{
                    id: 'ChangePasswordModalId',
                    title: 'Ubah Password',
                    submitLabel: 'Ubah Password'
                },
                form:{
                    id: 'ChangePasswordFormId',
                    parameters:{
                        old_password: null,
                        new_password: null,
                        new_password_confirmation: null,
                    }
                }
            }
        }
    },
    computed:{
        ...mapGetters('auth',['user']),
    },
    methods:{
        ...mapActions('auth',['logout']),
        ...mapActions('profile',['updatePassword']),

        changePasswordResetHandler(){
            for(var x in this.changePassword.form.parameters){
                this.changePassword.form.parameters[x] = null
            }
        },
        changePasswordHandler(){
            this.changePasswordResetHandler();
            this.$form.clearError(this.changePassword.form.id);
            this.$modal.show(this.changePassword.modal.id);
        },
        changePasswordSubmitHandler(){
            this.$loader.show();
            this.updatePassword(this.changePassword.form.parameters)
                .then(resp => {
                    this.$toast.success(resp.message);
                    this.$modal.hide(this.changePassword.modal.id);
                })
                .catch(err => {
                    this.$form.setError(this.changePassword.form.id, err.message);
                })
                .then(resp => {
                    this.$loader.hide();
                })
        },
        logoutHandler(){
            this.$alert.show({
                variant: 'danger',
                iconHtml: '<i class="fas fa-sign-out" style="font-size:40px;"></i>',
                confirmText: 'Logout',
                onConfirm: () => {
                    this.$loader.show();
                    this.logout()
                        .then(resp => {
                            this.$router.push(constants.login);
                        })
                        .then(resp => {
                            this.$loader.hide();
                        })
                }
            });
        }
    }
}
</script>

<style lang="scss">
.navbar-nav{
    .nav-link{
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>
