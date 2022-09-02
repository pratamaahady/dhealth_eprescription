<template>
    <div class="container-fluid">
        <Table
            :id="table.id"
            :headers="table.headers"
            :columns="table.columns"
            :datas="loadObats"
            :hideCheckbox="true">

            <template #action-header-left>
                <button class="btn btn-sm btn-info" @click.prevent="createHandler">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </template>

            <template #3="{data}">
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
                id: 'ObatTableID',
                headers: [
                    "Kode Obat",
                    "Nama Obat",
                    "Stok",
                    ""
                ],
                columns: [
                    { data: "obatalkes_kode" },
                    { data: "obatalkes_nama" },
                    { data: "stok" },
                    {
                        data: "obatalkes_id",
                        searchable: false,
                        sortable: false,
                        class: 'cell-fit-content',
                    },
                ],
            };
        }
    },
    methods:{
        ...mapActions('obat', ['loadObats','deleteObat']),
        createHandler(){
            this.$router.push({
                name: 'obat-create',
            })
        },
        editHandler(id){
            this.$router.push({
                name: 'obat-edit',
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
                    this.deleteObat(id)
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
