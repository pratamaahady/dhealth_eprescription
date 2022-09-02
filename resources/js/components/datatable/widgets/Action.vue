<template>
    <div class="basic-dropdown">
        <div class="dropdown dropdown-dark">
            <button type="button" class="btn btn-sm btn-dark dropdown-toggle px-3 py-1" data-toggle="dropdown">
                Action
            </button>
            <div class="dropdown-menu">
                <slot></slot>
                <TableActionButton :label="editLabel" @click.native="editHandler" v-if="onEdit" :disabled="disabledEdit">
                    <template #icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                            <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line>
                        </svg>
                    </template>
                </TableActionButton>
                <TableActionButton :label="deleteLabel" @click.native="deleteHandler" v-if="onDelete" :disabled="disabledDelete">
                    <template #icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="4" y1="7" x2="20" y2="7"></line>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        </svg>
                    </template>
                </TableActionButton>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        data: String|Number|Array|Object,
        editLabel:{
            type: String,
            default: 'Edit'
        },
        onEdit: Function,
        disabledEdit: {
            type: Boolean,
            default: false,
        },
        deleteLabel:{
            type: String,
            default: 'Remove'
        },
        onDelete: Function,
        disabledDelete: {
            type: Boolean,
            default: false,
        },
    },
    methods:{
        editHandler(){
            if(this.onEdit){
                this.onEdit(this.data);
            }
        },
        deleteHandler(){
            this.$alert.show({
                icon: 'trash',
                text:'Once deleted, you will not be able to recover this Data !',
                variant: 'danger',
                confirmText: 'Delete',
                onConfirm: () => {
                    if(this.onDelete){
                        this.onDelete(this.data);
                    }
                }
            });
        },
    }
}
</script>