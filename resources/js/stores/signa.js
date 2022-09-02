import { http, httpParam } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        signas: [],
        signa: null,
    },
    getters:{
        signas: state => state.signas,
        signa: state => state.signa,
    },
    mutations: {
        setSignas(state, signas){
            state.signas = signas;
        },
        removeSignas(state){
            state.signas = [];
        },
        setSigna(state, signa){
            state.signa = signa;
        },
        removeSigna(state){
            state.signa = null;
        },
    },
    actions: {
        loadSignas({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`signa`, {params})
                    .then(resp => {
                        commit('setSignas', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeSignas');
                        reject(err)
                    })
            })
        },
        loadSigna({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`signa/${id}`)
                    .then(resp => {
                        commit('setSigna', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeSigna');
                        reject(err)
                    })
            })
        },
        createSigna({commit},params){
            return new Promise((resolve, reject) => {
                http.post(`signa`, params)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateSigna({commit}, {id, params}){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`signa/${id}`, httpParam.toPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },
        deleteSigna({commit}, id){
            return new Promise((resolve, reject) => {
                http.delete(`signa/${id}`)
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
