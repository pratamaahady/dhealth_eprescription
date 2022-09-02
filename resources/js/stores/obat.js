import { http, httpParam } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        obats: [],
        obat: null,
    },
    getters:{
        obats: state => state.obats,
        obat: state => state.obat,
    },
    mutations: {
        setObats(state, obats){
            state.obats = obats;
        },
        removeObats(state){
            state.obats = [];
        },
        setObat(state, obat){
            state.obat = obat;
        },
        removeObat(state){
            state.obat = null;
        },
    },
    actions: {
        loadObats({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`obatalkes`, {params})
                    .then(resp => {
                        commit('setObats', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeObats');
                        reject(err)
                    })
            })
        },
        loadObat({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`obatalkes/${id}`)
                    .then(resp => {
                        commit('setObat', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeObat');
                        reject(err)
                    })
            })
        },
        createObat({commit},params){
            return new Promise((resolve, reject) => {
                http.post(`obatalkes`, params)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateObat({commit}, {id, params}){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`obatalkes/${id}`, httpParam.toPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },
        deleteObat({commit}, id){
            return new Promise((resolve, reject) => {
                http.delete(`obatalkes/${id}`)
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
