import constants from "@/configs/constants";
import store from '@/configs/store';

export default {
    guest: (from, to, next) => {
        if(localStorage.getItem('access_token')){
            next(constants.home);
        }
        next();
    },
    auth: async (from, to, next, store) => {
        if(! localStorage.getItem('access_token')){
            next(constants.login);
        }

        if(!store.state.auth.logged_in){
            await store.dispatch('auth/checkToken')
        }

        next();
    },
    setPageTitle: (from, to, next, store) => {
        var pageTitle = to.meta.title ?? to.name;
        store.dispatch('layout/setPageTitle', pageTitle);
    }
}

