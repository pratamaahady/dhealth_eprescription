import { http, httpParam } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        settings: [],
        setting: null,
    },
    getters:{
        settings: state => _.chain(state.settings).keyBy('setting_title').mapValues(setting => setting.setting_value).value(),
        setting: state => state.setting,
    },
    mutations: {
        setSettings(state, settings){
            state.settings = settings;
        },
        removeSettings(state){
            state.settings = [];
        },
        setSetting(state, setting){
            state.setting = setting;
        },
        removeSetting(state){
            state.setting = null;
        },
    },
    actions: {
        loadSettings({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`setting`, {params})
                    .then(resp => {
                        commit('setSettings', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeSettings');
                        reject(err)
                    })
            })
        },
        loadGeneralSettings({commit}, params){
            return new Promise((resolve, reject) => {
                http.get(`general/setting`, {params})
                    .then(resp => {
                        commit('setSettings', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeSettings');
                        reject(err)
                    })
            })
        },
        loadSetting({commit}, id){
            return new Promise((resolve, reject) => {
                http.get(`setting/${id}`)
                    .then(resp => {
                        commit('setSetting', resp.data);
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('removeSetting');
                        reject(err)
                    })
            })
        },
        createSetting({commit},params){
            return new Promise((resolve, reject) => {
                http.post(`setting`, params)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateSetting({commit}, {id, params}){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`setting/${id}`, httpParam.toPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },
        deleteSetting({commit}, id){
            return new Promise((resolve, reject) => {
                http.delete(`setting/${id}`)
                    .then(resp => {
                        resolve(resp)
                    })
                    .catch(err => {
                        reject(err)
                    })
            });
        },
        updateSettingBulk({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    http
                        .post(`setting/update_bulk`, httpParam.toFormDataPut(params))
                        .then(resp => {
                            resolve(resp)
                        })
                        .catch(err => {
                            reject(err)
                        })
                }
            )
        },    },
};
