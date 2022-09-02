import { http, httpParam, httpOpen } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        reseps: [],
        resep: null,
    },
    getters:{
        reseps: state => state.reseps,
        resep: state => state.resep,
    },
    mutations: {
        setReseps(state, reseps){
            state.reseps = reseps;
        },
        removeReseps(state){
            state.reseps = [];
        },
        setResep(state, resep){
            state.resep = resep;
        },
        removeResep(state){
            state.resep = null;
        },
    },
    actions: {
        loadReseps({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`resep`, {params})
                    .then(resp => {
                        commit('setReseps', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeReseps');
                        reject(err)
                    })
            })
        },
        loadResep({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`resep/${id}`)
                    .then(resp => {
                        commit('setResep', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeResep');
                        reject(err)
                    })
            })
        },
        createResep({commit},params){
            return new Promise((resolve, reject) => {
                http.post(`resep`, params)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateResep({commit}, {id, params}){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`resep/${id}`, httpParam.toPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },
        deleteResep({commit}, id){
            return new Promise((resolve, reject) => {
                http.delete(`resep/${id}`)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        pdfResep({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`resep/${id}/pdf`)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        }
    },
};
