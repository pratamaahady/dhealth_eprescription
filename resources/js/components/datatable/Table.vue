<template>
    <div :class="['card table-wrapper', hideCard ? 'card-disabled' : '']">
        <div :class="['card-header border-bottom w-100 px-4 flex-column flex-md-row align-items-center', hideHeader ? 'd-none' : 'd-flex']">
            <div class="d-flex justify-content-between align-items-center w-100 w-md-auto">
                <TableAction :onDelete="checkedRowsDeleteHandler" class="mr-3" v-if="!hideCheckbox">
                    <slot name="action-checkbox" />
                </TableAction>
                <slot name="action-header-left" />
                <h4 class="mb-0 table-title" v-if="title" :class="titleClass" v-html="title"></h4>
            </div>
            <div class="ml-auto w-100 w-md-auto d-flex align-items-center mt-3 mt-md-0">
                <slot name="action-header-right" />
                <Search class="w-100 w-md-auto" v-model="search" :placeholder="searchPlaceholder"/>
                <VisibleColumn class="ml-2" :options="headers" v-model="visibleColumns"/>
                <Export class="ml-2" :toPdf="exportToPdf" :toExcel="exportToExcel" :toCsv="exportToCsv" v-if="showExport"/>
            </div>
        </div>

        <div class="card-body p-0">
            <div :class="(responsive) ? 'table-responsive' : ''">
                <table :class="['table card-table table-vcenter text-nowrap datatable table-hover-custom', withBorder ? 'table-border' : '']" :id="id">
                    <thead>
                        <tr :class="[ transparentHeader ? '' : 'header-colored']">
                            <th v-if="!hideCheckbox" class="checkboxCol">
                                <input type="checkbox" v-model="isCheckedAllRow"/>
                            </th>
                            <th v-if="withCounter">
                                No.
                            </th>
                            <template v-for="(header, headerIndex) in _headers">
                                <th :key="headerIndex" v-if="visibleColumns.indexOf(headerIndex) != -1">
                                    <div :class="['d-flex align-items-center justify-content-between', (isSortable(headerIndex) && sortable) ? 'clickable' : '']" @click.prevent="setSort(headerIndex)">
                                        <span v-html="header"></span>
                                        <div v-if="isSortable(headerIndex) && sortable" class="ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" :class="['bi bi-arrow-down sort-icon', (sort.data == headerIndex && sort.direction == 'DESC') ? 'sort-active' : '']" viewBox="0 0 16 16" style="margin-right: -8px;">
                                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" :class="['bi bi-arrow-up sort-icon', (sort.data == headerIndex && sort.direction == 'ASC') ? 'sort-active' : '']" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </th>
                            </template>
                        </tr>
                        <tr v-if="!hideSearchColumn">
                            <th v-if="!hideCheckbox"></th>
                            <th v-if="withCounter"></th>
                            <th v-for="(column,columnIndex) in columns" :key="columnIndex" :class="[column.class]">
                                <template v-if="visibleColumns.indexOf(columnIndex) != -1 && column.searchable != false">
                                    <slot :name="'filter-'+columnIndex"/>
                                    <Search v-model="column.search" :placeholder="headers[columnIndex]" v-if="!hasScopedSlot('filter-'+columnIndex)" :onSubmit="init"/>
                                </template>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="table-loading" v-if="loading">
                            <div class="spinner-border" role="status"></div>
                        </div>
                        <template v-if="_rows.length > 0">
                            <tr v-for="(row, rowIndex) in _rows" :key="rowIndex" :class="[(onRowClick) ? 'clickable' : '']" @click="rowClickHandler(row)">
                                <td v-if="!hideCheckbox" class="checkboxCol">
                                    <input type="checkbox" v-model="row._isChecked" :checked="row._isChecked" @change="checkboxChangeHandler"/>
                                </td>
                                <td v-if="withCounter" class="cell-fit-content text-bold text-center">
                                    {{ rowIndex + 1 }}
                                </td>
                                <template v-for="(column,columnIndex) in columns" >
                                    <td :key="columnIndex" :class="[column.class, column.action ? 'column-action' : '']" v-if="visibleColumns.indexOf(columnIndex) != -1">
                                        <slot v-bind:data="colData(column.data,row)" v-bind:row="row" v-bind:rowIndex="rowIndex" :name="columnIndex"/>
                                        <span v-html="col(column,row)" v-if="!hasScopedSlot(columnIndex)"></span>
                                    </td>
                                </template>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-if="!hasScopedSlot('extendRow')">
                                <td :colspan="columns.length+1" class="text-center py-3">No Record Data.</td>
                            </tr>
                        </template>
                        <slot name="extendRow"/>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex align-items-center" v-if="!hideFooter">
            <Limit v-model="meta.limit" :total="meta.total"/>
            <Paginate v-model="meta.current_page" :current-page="meta.current_page" :total-page="meta.last_page" class="ml-auto" :disabled="loading"/>
        </div>
    </div>
</template>
<script>
import Paginate from './widgets/Paginate.vue'
import Search from './widgets/Search.vue'
import Limit from './widgets/Limit.vue'
import VisibleColumn from './widgets/VisibleColumn.vue'
import Export from './widgets/Export.vue'
import RightClickMenu from './widgets/RightClickMenu.vue'

export default {
    components: { Search, Paginate, Limit, VisibleColumn, Export, RightClickMenu },
    props: {
        id:{
            type: String,
            requierd: true,
        },
        datas: {
            type: Function|Object|Array,
            required: true
        },
        headers: {
            type: Array,
            required: true
        },
        columns: {
            type: Array,
            required: true
        },
        order: Object,

        /* Actions Props */
        onDeleteSelected: Function,

        /* Layout Props */
        title: String,
        titleClass: String,
        "search-placeholder": String,
        responsive: {
            type: Boolean,
            default: true,
        },
        showExport: Boolean,
        exportToPdf: Function,
        exportToCsv: Function,
        exportToExcel: Function,
        hideCard: Boolean,
        hideCheckbox: Boolean,
        disablePaginate: Boolean,
        hideHeader: Boolean,
        hideFooter: Boolean,
        hideSearchColumn: {
            type: Boolean,
            default: true
        },
        transparentHeader: {
            type: Boolean,
            default: true,
        },
        onRowClick: Function,
        params: Object,
        withCounter: Boolean,
        withBorder: Boolean,
        sortable: {
            type: Boolean,
            default: true
        },
        afterInit: Function,
    },
    data() {
        return {
            loading: false,
            data: [],
            meta: {
                from: 1,
                to: 1,
                total: 1,
                limit: 10,
                current_page: 1,
                last_page: 1,
            },
            search: null,
            sort:{
                data: (this.order && this.order.hasOwnProperty('column')) ? this.order.column : 0,
                direction: (this.order && this.order.hasOwnProperty('direction')) ? this.order.direction.toUpperCase() : "DESC",
            },

            visibleColumns: this.headers ?? [],
            isCheckedAllRow: false,
        };
    },
    computed: {
        /* Data */
        _rows: function() {
            return this.data ?? [];
        },

        /* Payload */
        payload(){
            return {
                ...this._payloadColumns,
                ...this._payloadSearch,
                ...this._payloadSort,
                ...this._payloadLimit,
                ...this._payloadPage,
                ...this.params,
            }
        },
        _payloadColumns(){
            var payload = {};

            this.columns.forEach((column,index) => {
                payload[`column[${index}][data]`] = column.data;
                payload[`column[${index}][search]`] = column.search;
                payload[`column[${index}][searchable]`] = this.isSearchable(index);
            });

            return payload;
        },
        _payloadSearch(){
            return {
                search: this.search,
            }
        },
        _payloadSort(){
            var payload = {};

            for(var key in this.sort){
                payload[`sort[${key}]`] = this.sort[key];
            }

            return payload;
        },
        _payloadLimit(){
            return {
                limit: this.meta.limit,
            }
        },
        _payloadPage(){
            return {
                page: this.meta.current_page,
            }
        },

        /* Layout */
        _headers(){
            return this.headers;
        },
    },
    watch:{
        payload(val){
            this.init();
        },
        isCheckedAllRow(val){
            this._rows.forEach((row) => {
                row._isChecked = val;
            });
        },
        datas(val){
            this.init()
        },
        'meta.limit': function(val){
            if((val * this.meta.current_page) > this.meta.total){
                this.meta.current_page = 1;
            }
        }
    },
    methods: {
        /* Layout */
        setLoading(status) {
            this.loading = status;
        },

        /* Table */
        init(){
            return new Promise(
                (resolve, reject) => {
                    if(!this.loading){
                        this.setLoading(true);
                        this.isCheckedAllRow = false;

                        if(this.datas instanceof Function){
                            var payload = {};

                            this.columns.forEach((column,index) => {
                                payload[`column[${index}][data]`] = column.data;
                                payload[`column[${index}][search]`] = column.search;
                                payload[`column[${index}][searchable]`] = this.isSearchable(index);
                            });

                            this.datas({ ...this.payload, ...payload })
                                .then(resp => {
                                    this.setDataServerSide(resp);
                                    resolve(resp)
                                })
                                .catch(err => {
                                    reject(err);
                                })
                                .then(resp => {
                                    this.setLoading(false);
                                });
                        }
                        else if(this.datas instanceof Array){
                            this.setDataArray();
                            this.setLoading(false);
                            resolve(true)
                        }
                    }
                }
            )
        },
        reload(){
            this.init();
        },
        col: function(column, row) {
            var html;

            var data = this.colData(column.data, row);

            if (column.render !== undefined) {
                html = column.render(data, row);
            } else {
                html = data;
            }

            return html;
        },
        colData: function(data,row){
            if(data.indexOf('.') != -1){
                var col = data.split(".");
                var colData = col[0];

                col.splice(0,1);
                col = col.join('.');
                if(row[colData]){
                    return this.colData(col, row[colData]);
                }else{
                    return null;
                }
            }else{
                return row[data];
            }
        },

        /*  */
        setDataServerSide(res){
            this.data = res.data;
            if(res.meta){
                this.meta.total = res.meta.total ?? this.meta.total;
                this.meta.current_page = res.meta.current_page ?? this.meta.current_page;
                this.meta.from = res.meta.from ?? this.meta.from;
                this.meta.to = res.meta.to ?? this.meta.to;
                this.meta.last_page = res.meta.last_page ?? this.meta.last_page;
            }
        },
        setDataArray(){
            this.data = this.datas;
        },
        setSort(index) {
            if(this.isSortable(index) && this.sortable){
                this.sort = {
                    data: index,
                    direction: this.sort.direction == 'ASC' ? 'DESC' : 'ASC',
                }
            }
        },

        /* Condition */
        hasScopedSlot(name){
            return !!this.$scopedSlots[name];
        },
        hasSlot(name){
            return !!this.$slots[name];
        },
        isSortable(index){
            if(this.columns[index]){
                if(this.columns[index].sortable === false){
                    return false;
                }
            }
            return true;
        },
        isSearchable(index){
            if(this.columns[index]){
                if(this.columns[index].searchable === false){
                    return false;
                }
            }
            return true;
        },

        checkboxChangeHandler(){
            this.isCheckedAllRow = _.every(this._rows, row => row._isChecked == true);
        },
        checkedRowsDeleteHandler(){
            var _checkedRows = _.filter(this._rows, row => row._isChecked == true);
            if(this.onDeleteSelected){
                this.onDeleteSelected(_checkedRows);
            }
        },

        rowClickHandler(row){
            if(this.onRowClick){
                this.onRowClick(row);
            }
        }
    },
    mounted(){
        this.init()
            .then(resp => {
                if(this.afterInit){
                    var payload = {};

                    this.columns.forEach((column,index) => {
                        payload[`column[${index}][data]`] = column.data;
                        payload[`column[${index}][search]`] = column.search;
                        payload[`column[${index}][searchable]`] = this.isSearchable(index);
                    });
                    this.afterInit({ ...this.payload, ...payload });
                }
            });
    },
    created(){
        this.$table.components.push(this);
        _.each(this.columns, (item,index) => {
            if(item.hide){
                this.headers.splice(index,1);
                this.columns.splice(index,1);
            }
        })
    },
    destroyed(){
        const index = this.$table.components.findIndex((component) => component.id === this.id);
        this.$table.components.splice(index, 1);
    },
};

</script>
<style lang="scss" scoped>
    @import './styles/Table.scss';
</style>
