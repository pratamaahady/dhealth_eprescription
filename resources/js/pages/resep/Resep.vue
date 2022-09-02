<template>
    <div class="container-fluid">
        <Table
            :id="table.id"
            :headers="table.headers"
            :columns="table.columns"
            :datas="loadReseps"
            :hideCheckbox="true">

            <template #action-header-left>
                <button class="btn btn-sm btn-info" @click.prevent="createHandler">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
            </template>

            <template #1="{data}">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Print">
                    <button class="btn btn-sm btn-info p-2" @click.prevent="printHandler(data)">
                        <i class="fas fa-print"></i>
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
                id: 'ResepTableID',
                headers: [
                    "Nama Pasien",
                    ""
                ],
                columns: [
                    { data: "nama_pasien" },
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
        ...mapActions('resep', ['loadReseps','deleteResep','pdfResep']),
        createHandler(){
            this.$router.push({
                name: 'resep-create',
            })
        },
        b64toBlob(b64Data, contentType='', sliceSize=512){
            const byteCharacters = atob(b64Data);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                const slice = byteCharacters.slice(offset, offset + sliceSize);

                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
                }

                const byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }

            const blob = new Blob(byteArrays, {type: contentType});
            return blob;
        },
        printHandler(id){
            this.pdfResep(id)
                .then(resp => {
                    const blob = this.b64toBlob(resp.data.pdf, 'application/pdf');
                    const blobUrl = URL.createObjectURL(blob);

                    window.open(blobUrl, '_blank');
                })
        },
        deleteHandler(id){
            this.$alert.show({
                icon: 'trash',
                variant: 'danger',
                confirmText: 'Delete',
                onConfirm: () => {
                    this.$loader.show();
                    this.deleteResep(id)
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
