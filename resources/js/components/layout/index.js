import LayoutBlank from './LayoutBlank.vue'
import LayoutContent from './LayoutContent.vue'

export default {
    install(vue, options) {
        vue.component('LayoutBlank', LayoutBlank);
        vue.component('LayoutContent', LayoutContent);
    }
}
