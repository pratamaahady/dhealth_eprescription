import BasicModal from './BasicModal.vue'
import AlertModal from './AlertModal.vue'

const ModalPlugin = {
    // eslint-disable-next-line no-unused-vars
    install(Vue, options) {
        Vue.component('BasicModal', BasicModal);
        Vue.component('AlertModal', AlertModal);

        Vue.prototype.$modal = {
            components: [],
            show(id){
                var component = _.find(this.components, {id:id});
                if(component) component.show();
            },
            hide(id){
                var component = _.find(this.components, {id:id});
                if(component) component.hide();
            },
        }

        Vue.prototype.$alert = {
            component: null,
            show(propsData={}){
                const body = document.querySelector('body')

                const container = document.createElement('div')
                container.id = 'alert-modal-wrapper';
                body.appendChild(container)

                const mountNode = document.createElement('div')
                mountNode.id = 'mount-node'

                container.appendChild(mountNode)

                let alertModal = Vue.extend(AlertModal)

                this.component = new alertModal({  propsData: propsData }).$mount('#mount-node')
                this.component.show();
            },
            hide(){
                document.querySelector('#alert-modal-wrapper').remove()
            }
        }
    }
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(ModalPlugin)
}

export default ModalPlugin