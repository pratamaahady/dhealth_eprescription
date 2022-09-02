<template>
    <form class="_formAuth" @submit.prevent="submitHandler">
        <div class="_formAuthBrand mb-4">
            <img src="@/assets/images/logo.webp" class="_formAuthBrandLogo"/>
        </div>
        <div class="alert alert-danger" v-if="error_message">{{ error_message }}</div>
        <div class="form-group mb-2">
            <input class="form-control radius-0" type="text" placeholder="Username" v-model="params.username" autofocus/>
        </div>
        <div class="form-group mb-4">
            <input class="form-control radius-0" type="password" placeholder="Password" v-model="params.password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-lg w-100 radius-0 _formAuthSubmit" type="submit">Login</button>
        </div>
    </form>
</template>
<script>
import constants from '@/configs/constants'
import { mapActions } from 'vuex';

export default {
    data(){
        return {
            error_message: null,
            params:{
                username: null,
                password: null
            }
        }
    },
    methods:{
        ...mapActions('auth',['login']),
        submitHandler(){
            this.$loader.show();
            this.login(this.params)
                .then(resp => {
                    window.location.href = constants.home;
                })
                .catch(err => {
                    this.error_message = err.message;
                })
                .then(resp => {
                    this.$loader.hide();
                })
        }
    }
}
</script>
<style lang="scss">
._formAuth{
    width: 330px;
    padding: 5px;
    margin: 3rem auto;

    ._formAuthBrand{
        text-align: center;

        ._formAuthBrandLogo{
            height: 100px;
            margin-bottom: 5px;
        }
        ._formAuthBrandText{
            color: #425AAD;
            font-size: 16px;
            font-weight: bold;
        }
    }

    .form-control{
        padding: 10px;
        font-size: 16px;
    }

    ._formAuthSubmit{
        background-color: #3b5998;
        border: #3b5998;
        color: white;

        &:hover{
            color: white;
            background-color: #193979;
            border: #2f477a;
        }

        &:focus{
            color: white;
            background-color: #3b5998;
            border: #3b5998;
        }

        &:active{
            color: white;
            background-color: #3b5998;
            border: #3b5998;
        }

    }
}
</style>
