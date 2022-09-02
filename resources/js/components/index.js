import Layout from './layout'
import Modal from './modal'
import Loader from './loader'
import Form from './form'
import Toast from './toast'
import Datatable from './datatable'
import Card from './card'
import Import from './import'

export default {
    install(vue, options) {
        vue.use(Layout)
        vue.use(Modal)
        vue.use(Loader)
        vue.use(Form)
        vue.use(Toast)
        vue.use(Datatable)
        vue.use(Card)
        vue.use(Import)
    }
}
