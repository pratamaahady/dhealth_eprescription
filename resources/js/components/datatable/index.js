import Table from './Table.vue'
import TableAction from './widgets/Action.vue'
import TableActionButton from './widgets/ActionButton.vue'

const TablePlugin = {
    // eslint-disable-next-line no-unused-vars
    install(Vue, options){
        Vue.component('Table', Table);
        Vue.component('TableAction', TableAction);
        Vue.component('TableActionButton', TableActionButton);

        Vue.prototype.$table = {
            components: [],
            checkedRows(id){
                var component = _.find(this.components,{ id: id });
                if(component){
                    return _.filter(component._rows, row => row._isChecked == true);
                }else{
                    return [];
                }
            },
            reload(id){
                var component = _.find(this.components,{ id: id });
                if(component) component.reload();
            }
        }
    }
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(TablePlugin)
}

export { Table, TableAction, TableActionButton }
export default TablePlugin
