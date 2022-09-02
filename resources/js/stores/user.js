import { http, httpParam } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        users: [],
        user: null,
    },
    getters:{
        users: state => state.users,
        user: state => state.user,
    },
    mutations: {
        setUsers(state, users){
            state.users = users;
        },
        removeUsers(state){
            state.users = [];
        },
        setUser(state, user){
            state.user = user;
        },
        removeUser(state){
            state.user = null;
        },
    },
    actions: {
        loadUsers({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`user`, {params})
                    .then(resp => {
                        commit('setUsers', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeUsers');
                        reject(err)
                    })
            })
        },
        loadUser({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`user/${id}`)
                    .then(resp => {
                        commit('setUser', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeUser');
                        reject(err)
                    })
            })
        },
        createUser({commit},params){
            return new Promise((resolve, reject) => {
                http.post(`user`, params)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateUser({commit}, {id, params}){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`user/${id}`, httpParam.toPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },
        deleteUser({commit}, id){
            return new Promise((resolve, reject) => {
                http.delete(`user/${id}`)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
    },
};
