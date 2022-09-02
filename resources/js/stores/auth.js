import { http, setToken, removeToken } from '@/utils/http'

export default {
    namespaced: true,
    state: {
        access_token: localStorage.getItem('access_token') || '',
        user: localStorage.getItem('user') || '',
        logged_in: false,
    },
    getters:{
        access_token: state => state.token,
        user: state => state.user ? JSON.parse(state.user) : '',
        logged_in: state => state.logged_in,
    },
    mutations: {
        setUser(state, user){
            state.user = JSON.stringify(user);
            localStorage.setItem('user', state.user);
        },
        removeUser(state){
            state.user = '';
            localStorage.removeItem('user');
        },
        setAccessToken(state, accessToken){
            state.access_token = accessToken;
            localStorage.setItem('access_token', state.access_token);
        },
        removeAccessToken(state){
            state.access_token = '';
            localStorage.removeItem('access_token');
        },
        setLoggedIn(state, status){
            state.logged_in = status;
            if(!status){
                removeToken();
            }
        }
    },
    actions: {
        login({commit}, params){
            return new Promise(
                (resolve, reject) => {
                    axios.get('/sanctum/csrf-cookie')
                        .then(resp => {
                            http.post('auth/login', params)
                                .then(resp => {
                                    commit('setAccessToken', resp.data.token);
                                    commit('setUser', resp.data);
                                    setToken(resp.data.token);

                                    resolve(resp);
                                })
                                .catch(err => {
                                    commit('removeAccessToken');
                                    commit('removeUser');
                                    removeToken();

                                    reject(err);
                                })
                        })
                }
            )
        },
        logout({commit}){
            return new Promise(
                (resolve, reject) => {
                    http.delete('auth/logout')
                        .then(resp => {})
                        .catch(err => console.log(err))
                        .then(resp => {
                            commit('removeAccessToken');
                            commit('removeUser');
                            removeToken();
                            resolve(true)
                        });
                }
            )
        },
        checkToken({commit}){
            return new Promise(
                (resolve, reject) => {
                    http.get('auth/verify_token')
                        .then(resp => {
                            commit('setLoggedIn', true)
                            resolve(resp)
                        })
                        .catch(err => {
                            commit('setLoggedIn', false)
                            reject(err)
                        })
                }
            )
        }
    },
};
