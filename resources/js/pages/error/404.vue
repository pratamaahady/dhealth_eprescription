<template>
    <section class="page_404">
        <div class="container">
            <div class="row h-100 align-items-center">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">404</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">Look like you're lost</h3>
                            <p>the page you are looking for not avaible!</p>
                            <a href="javascript:;" class="link_404" @click.prevent="goHomeHandler">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import constants from '@/configs/constants'
export default {
    methods:{
        goHomeHandler(){
            window.location.href = constants.home
        }
    }
}
</script>
<style lang="scss">
.page_404{
    background:#fff;
    font-family: 'Arvo', serif;

    img{ width:100%; }

    .four_zero_four_bg{
        background-image: url('@/assets/images/404.gif');
        height: 400px;
        background-position: center;

        h1{ font-size:80px; }
    }

    .contant_box_404{
        margin-top:-50px;

        .link_404{
            color: #fff!important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }
    }

}
</style>
