<template>
    <div class="right-click-menu" v-click-outside="closeMenu" v-if="showMenu" :style="{top: top+'px', left: left+'px' }">
        <a href="javascript:;" class="right-click-menu-item">Edit</a>
        <a href="javascript:;" class="right-click-menu-item">Delete</a>
    </div>
</template>
<script>
export default {
    data(){
        return{
            showMenu: false,
            top: 0,
            left: 0
        }
    },
    methods:{
        openMenu(e){
            var parentEl = e.target.parentElement.closest('.table-wrapper');
            var parentElPosition = parentEl.getBoundingClientRect();
            this.top =  -parentElPosition.y + e.y;
            this.left = -parentElPosition.x + e.x;

            this.showMenu = true;

            e.preventDefault();
        },
        closeMenu(){
            this.showMenu = false
        }
    },
    directives:{
        'click-outside': {
            bind (el, binding, vnode) {
                document.body.addEventListener('click', function (event) {
                    if (!(el == event.target || el.contains(event.target))) {
                        vnode.context[binding.expression](event);
                    }
                })
            },
            unbind(el) {
                document.body.removeEventListener('click', function (event) {
                    if (!(el == event.target || el.contains(event.target))) {
                        vnode.context[binding.expression](event);
                    }
                })
            },
        }
    }
}
</script>
<style lang="scss" scoped>
.right-click-menu{
    position: absolute;
    background: white;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba($color: #000000, $alpha: .2);
    padding: 5px 0;

    .right-click-menu-item{
        display: block;
        padding: 5px 20px;
        &a{
            text-decoration: none;
        }

        &:hover{
            background: #f8f9fa;
            color:black;
        }

        &:active{
            background: #555555;
            color: white;
        }
    }
}
</style>