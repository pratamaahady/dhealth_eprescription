import Loader from './Loader.vue'

const LoaderPlugin = {
    // eslint-disable-next-line no-unused-vars
    install(Vue, options) {
        Vue.component('Loader', Loader);

        Vue.prototype.$loader = {
            component: null,
            show(){
                if(this.component == null){
                    const body = document.querySelector('body')

                    const container = document.createElement('div')
                    container.id = 'preloader-wrapper';
                    body.appendChild(container)

                    const mountNode = document.createElement('div')
                    mountNode.id = 'preloader-mount-node'

                    container.appendChild(mountNode)

                    let loader = Vue.extend(Loader)
                    this.component = new loader().$mount('#preloader-mount-node')
                }

                this.component.show();
            },
            hide(){
                if(this.component){
                    this.component.hide();
                }
            }
        }
    }
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(LoaderPlugin)
}

export default LoaderPlugin