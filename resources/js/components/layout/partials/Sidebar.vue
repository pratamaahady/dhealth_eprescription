<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/" class="brand-link text-center">
      <span class="brand-text">{{ application_name }}</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
            <li class="nav-item">
                <router-link :to="{ name: 'home' }" active-class="active" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </router-link>
            </li>
            <li :class="['nav-item', subIsActive(menu.childrens) ? 'menu-open' : '']" v-for="(menu, menuIndex) in menus" :key="menuIndex">
                <template v-if="menu.childrens.length > 0">
                    <a href="javascript:;" :class="['nav-link', subIsActive(menu.childrens) ? 'active' : '']">
                        <i :class="['nav-icon', menu.menu_icon ]"></i>
                        <p>
                            {{ menu.menu_name }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" v-for="(menuChild, menuChildIndex) in menu.childrens" :key="menuChildIndex">
                            <router-link :to="menuChild.menu_link_target" active-class="active" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ menuChild.menu_name }}</p>
                            </router-link>
                        </li>
                    </ul>
                </template>
                <template v-else>
                    <router-link :to="menu.menu_link_target" active-class="active" class="nav-link">
                        <i :class="['nav-icon', menu.menu_icon ]"></i>
                        <p>{{ menu.menu_name }}</p>
                    </router-link>
                </template>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    computed: {
        ...mapGetters('layout',['application_name','application_logo','application_logo_text']),
        menus(){
            return [
                {
                    menu_name: 'Resep',
                    menu_link_target: '/resep',
                    menu_icon: 'fas fa-file-alt',
                    childrens: [],
                },
                {
                    menu_name: 'Master Data',
                    menu_link_target: null,
                    menu_icon: 'fas fa-th-list',
                    childrens: [
                        {
                            menu_name: 'Obat',
                            menu_link_target: '/master-data/obat',
                            menu_icon: 'fas fa-th-list',
                            childrens: [],
                        },
                        {
                            menu_name: 'Signa',
                            menu_link_target: '/master-data/signa',
                            menu_icon: 'fas fa-th-list',
                            childrens: [],
                        },
                    ],
                },
                {
                    menu_name: 'Pengguna',
                    menu_link_target: '/pengguna',
                    menu_icon: 'fas fa-user',
                    childrens: [],
                }
            ];
        }
    },
    methods:{
        subIsActive(childrens) {
            return childrens.some(children => {
                return this.$route.path.indexOf(children.menu_link_target) === 0 // current path starts with this path string
            })
        }
    },
    mounted(){
        require('@/assets/js/adminlte.min.js')
    }
}
</script>
