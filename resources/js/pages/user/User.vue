<template>
    <div class="container-fluid">
        <Table
            :id="table.id"
            :headers="table.headers"
            :columns="table.columns"
            :datas="loadUsers"
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
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Hapus" v-if="data != user.id">
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
        ...mapGetters('auth',['user']),
        table(){
            return {
                id: 'UserTableID',
                headers: [
                    "Nama",
                    "Username",
                    ""
                ],
                columns: [
                    { data: "name" },
                    { data: "username" },
                    {
                        data: "id",
                        searchable: false,
                        sortable: false,
                        class: 'cell-fit-content',
                    },
                ],
            };
        }
    },
    methods:{
        ...mapActions('user', ['loadUsers','deleteUser']),
        createHandler(){
            this.$router.push({
                name: 'user-create',
            })
        },
        editHandler(id){
            this.$router.push({
                name: 'user-edit',
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
                    this.deleteUser(id)
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
