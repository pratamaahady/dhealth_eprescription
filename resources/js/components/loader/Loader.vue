<template>
    <div class="loader" v-show="visible">
        <div class="loader2">
            <span></span>
            <span></span>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            visible: false,
        }
    },
    methods:{
        show(){
            this.visible = true;
        },
        hide(){
            this.visible = false;
        }
    }
}
</script>

<style lang="scss" scoped>
    .loader{
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0,0,0,.2);
        height: 100vh;
        width: 100vw;
        z-index: 9999;
        display: flex;
        align-items:center;
        justify-content:center;

        .loader3 {
            width:50px;
            height:50px;
            display:inline-block;
            padding:0px;
            text-align:left;

            span {
                position:absolute;
                display:inline-block;
                width:50px;
                height:50px;
                border-radius:100%;
                background:#3b5998;
                -webkit-animation:loader3 1.5s linear infinite;
                animation:loader3 1.5s linear infinite;
                &:last-child {
                    animation-delay:-0.9s;
                    -webkit-animation-delay:-0.9s;
                }
            }
        }

        @keyframes loader3 {
            0% {transform: scale(0, 0);opacity:0.8;}
            100% {transform: scale(1, 1);opacity:0;}
        }
        @-webkit-keyframes loader3 {
            0% {-webkit-transform: scale(0, 0);opacity:0.8;}
            100% {-webkit-transform: scale(1, 1);opacity:0;}
        }

    .loader2 {
        width:80px;
        height:80px;
        display:inline-block;
        padding:0px;
        border-radius:100%;
        border:10px solid;
        border-top-color:rgba(254, 168, 23, 0.65);
        border-bottom-color:rgba(57, 154, 219, 0.65);
        border-left-color:rgba(188, 84, 93, 0.95);
        border-right-color:rgba(137, 188, 79, 0.95);
        -webkit-animation: loader2 2s ease-in-out infinite alternate;
        animation: loader2 2s ease-in-out infinite alternate;
    }
    @keyframes loader2 {
        from {transform: rotate(0deg);}
        to {transform: rotate(720deg);}
    }
    @-webkit-keyframes loader2 {
        from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(720deg);}
    }

}
</style>
