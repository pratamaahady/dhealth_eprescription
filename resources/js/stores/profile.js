import http from '@/utils/http'

export default {
    namespaced: true,
    state: {
        profile: null,
        menus: [],
        permissions: [],
        route: null,
    },
    getters:{
        profile: state => state.profile,
        menus: state => state.menus,
        permissions: state => state.permissions,
        permission: state => _.find(state.permissions, (permission) => permission.menu_link_target == state.route.path),
    },
    mutations: {
        setProfile(state, profile){
            state.profile = profile;
        },
        removeProfile(state){
            state.profile = null;
        },
        setMenus(state, menus){
            state.menus = menus;
        },
        removeMenus(state){
            state.menus = [];
        },
        setPermissions(state, permissions){
            state.permissions = permissions;
        },
        removePermissions(state){
            state.permissions = [];
        },
        setRoute(state, route){
            state.route = route;
        },
        removeRoute(){
            state.route = null;
        },
    },
    actions: {
        loadProfile({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    http.get('profile', params)
                        .then(resp => {
                            commit('setProfile', resp.data)
                            resolve(resp);
                        })
                        .catch(err => {
                            commit('removeProfile');
                            reject(err);
                        })
                }
            )
        },
        loadMenus({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    http.get('profile/menu', params)
                        .then(resp => {
                            commit('setMenus', resp.data)
                            resolve(resp);
                        })
                        .catch(err => {
                            commit('removeMenus');
                            reject(err);
                        })
                }
            )
        },
        updatePassword({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    http.post('profile/change_password', params)
                        .then(resp => {
                            resolve(resp);
                        })
                        .catch(err => {
                            reject(err);
                        })
                }
            )
        },
        loadPermissions({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    http.get('profile/permission', params)
                        .then(resp => {
                            commit('setPermissions', resp.data)
                            resolve(resp);
                        })
                        .catch(err => {
                            commit('removePermissions');
                            reject(err);
                        })
                }
            )
        },
    },
};
