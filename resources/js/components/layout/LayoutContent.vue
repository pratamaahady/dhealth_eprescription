<template>
    <div class="wrapper">
        <Navbar></Navbar>
        <Sidebar></Sidebar>
        <div class="content-wrapper h-auto">
            <section class="content pt-3">
                <slot></slot>
            </section>
        </div>
        <Footer></Footer>
    </div>
</template>
<script>
import { mapActions } from 'vuex'
import Navbar from './partials/Navbar.vue'
import Sidebar from './partials/Sidebar.vue'
import Footer from './partials/Footer.vue'

export default {
    components:{
        Navbar,
        Sidebar,
        Footer,
    },
    data(){
        return {

        }
    },
    computed:{
        layout(){
            return this.$route.meta.layout;
        }
    },
    mounted(){
        require('bootstrap/dist/js/bootstrap.bundle')
        require('overlayscrollbars/js/jquery.overlayScrollbars.min.js')
        require('@/assets/js/adminlte.min.js')
    }
}
</script>
<style lang="scss" src="./LayoutContent.scss"></style>
