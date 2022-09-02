import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
const store = new Vuex.Store({
    modules: stores()
});

function stores(){
    var modules = {};
    const files = require.context('@/stores', true, /.js$/);
    files.keys().forEach((file) => {
        let filename = file.replace('./','').replace('.js','')
        modules[filename] = require('@/stores/'+filename).default;
    })
    return modules
}

export default store;
