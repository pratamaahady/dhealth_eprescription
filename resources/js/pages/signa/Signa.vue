<template>
    <div class="container-fluid">
        <Table
            :id="table.id"
            :headers="table.headers"
            :columns="table.columns"
            :datas="loadSignas"
            :hideCheckbox="true">

            <template #action-header-left>
                <button class="btn btn-sm btn-info" @click.prevent="createHandler">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </template>

            <template #2="{data}">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
                    <button class="btn btn-sm btn-warning p-2" @click.prevent="editHandler(data)">
                        <i class="fas fa-edit"></i>
                    </button>
                </span>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Hapus">
                    <button class="btn btn-sm btn-danger p-2" @click.prevent="deleteHandler(data)">
                        <i class="fas fa-trash"></i>
                    </button>
                </span>
            </template>
        </Table>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    computed:{
        table(){
            return {
                id: 'SignaTableID',
                headers: [
                    "Kode Signa",
                    "Nama Signa",
                    ""
                ],
                columns: [
                    { data: "signa_kode" },
                    { data: "signa_nama" },
                    {
                        data: "signa_id",
                        searchable: false,
                        sortable: false,
                        class: 'cell-fit-content',
                    },
                ],
            };
        }
    },
    methods:{
        ...mapActions('signa', ['loadSignas','deleteSigna']),
        createHandler(){
            this.$router.push({
                name: 'signa-create',
            })
        },
        editHandler(id){
            this.$router.push({
                name: 'signa-edit',
                params: { id }
            })
        },
        deleteHandler(id){
            this.$alert.show({
                icon: 'trash',
                variant: 'danger',
                confirmText: 'Delete',
                onConfirm: () => {
                    this.$loader.show();
                    this.deleteSigna(id)
                        .then(resp => {
                            this.$toast.success(resp.message);
                        })
                        .catch(err => {
                            this.$toast.error(err.message);
                        })
                        .then(resp => {
                            this.$loader.hide();
                            this.$table.reload(this.table.id);
                        })
                }
            });
        },
    }
}
</script>
