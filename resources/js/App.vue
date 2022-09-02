<template>
    <component :is="layout">
        <router-view></router-view>
    </component>
</template>
<script>
export default {
    computed:{
        layout(){
            switch(this.$route.meta.layout){
                case 'blank':
                    var layout = 'LayoutBlank';
                    break;
                default:
                    var layout = 'LayoutContent';
            }
            return layout;
        }
    },
}
</script>
