import Vue from 'vue'
import VueRouter from 'vue-router'
import middleware from '@/middlewares/router.middleware'
import store from './store'
import { http } from '@/utils/http'

function routes(){
    var routes = [];
    const files = require.context('@/routes', true, /.js$/);
    files.keys().forEach((file) => {
        let filename = file.replace('./','').replace('.js','')
        routes = [
            ...routes,
            ...require('@/routes/'+filename).default
        ]
    })
    return routes
}

Vue.use(VueRouter);
const router = new VueRouter({ mode: 'history', routes: routes() });

router.beforeEach((to, from, next) => {
    store.commit('profile/setRoute',to);
    if(to.meta.hasOwnProperty('middlewares')){
        var middlewares = to.meta.middlewares;
        if(Array.isArray(middlewares)){
            for(var x in middlewares){
                middleware[middlewares[x]](from, to, next, store);
            }
        }
    }

    next();
})

router.afterEach((to, from, next) => {
    middleware.setPageTitle(from ,to, next, store);
})

export default router;
