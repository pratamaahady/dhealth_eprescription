import Error404 from '@/pages/error/404.vue'
import Login from '@/pages/login/Login.vue'
import Home from '@/pages/home/Home.vue'
import User from '@/pages/user/User.vue'
import UserForm from '@/pages/user/UserForm.vue'
import Resep from '@/pages/resep/Resep.vue'
import ResepForm from '@/pages/resep/ResepForm.vue'

export default [
    {
        path: "*",
        component: Error404,
        meta:{
            layout: 'blank',
            title: "Not Found"
        }
    },
    {
        name: "login",
        path: "/",
        component: Login,
        meta:{
            layout: 'blank',
            middlewares: ['guest'],
            title: "Login",
        }
    },
    {
        name: "home",
        path: "/dashboard",
        component: Home,
        meta:{
            middlewares: ['auth'],
            title: "Beranda",
        },
    },

    /* User */
    {
        name: "user",
        path: "/pengguna",
        component: User,
        meta:{
            middlewares: ['auth'],
            title: "Pengguna",
        },
    },
    {
        name: "user-create",
        path: "/pengguna/buat",
        component: UserForm,
        meta:{
            middlewares: ['auth'],
            title: "Buat Pengguna",
        },
    },
    {
        name: "user-edit",
        path: "/pengguna/:id/ubah",
        component: UserForm,
        meta:{
            middlewares: ['auth'],
            title: "Ubah Pengguna",
        },
    },

    /* Resep */
    {
        name: "resep",
        path: "/resep",
        component: Resep,
        meta:{
            middlewares: ['auth'],
            title: "Resep",
        },
    },
    {
        name: "resep-create",
        path: "/resep/buat",
        component: ResepForm,
        meta:{
            middlewares: ['auth'],
            title: "Buat Resep",
        },
    },
    {
        name: "resep-edit",
        path: "/resep/:id/ubah",
        component: ResepForm,
        meta:{
            middlewares: ['auth'],
            title: "Ubah Resep",
        },
    },
]
