import Obat from '@/pages/obat/Obat.vue'
import ObatForm from '@/pages/obat/ObatForm.vue'
import Signa from '@/pages/signa/Signa.vue'
import SignaForm from '@/pages/signa/SignaForm.vue'

export default [
    /* Obat */
    {
        name: "obat",
        path: "/master-data/obat",
        component: Obat,
        meta:{
            middlewares: ['auth'],
            title: "Obat",
        },
    },
    {
        name: "obat-create",
        path: "/master-data/obat/buat",
        component: ObatForm,
        meta:{
            middlewares: ['auth'],
            title: "Buat Obat",
        },
    },
    {
        name: "obat-edit",
        path: "/master-data/obat/:id/ubah",
        component: ObatForm,
        meta:{
            middlewares: ['auth'],
            title: "Ubah Pengguna",
        },
    },

    /* Signa*/
    {
        name: "signa",
        path: "/master-data/signa",
        component: Signa,
        meta:{
            middlewares: ['auth'],
            title: "Signa",
        },
    },
    {
        name: "signa-create",
        path: "/master-data/signa/buat",
        component: SignaForm,
        meta:{
            middlewares: ['auth'],
            title: "Buat Signa",
        },
    },
    {
        name: "signa-edit",
        path: "/master-data/signa/:id/ubah",
        component: SignaForm,
        meta:{
            middlewares: ['auth'],
            title: "Ubah Signa",
        },
    },
]
