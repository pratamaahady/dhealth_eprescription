<template>
    <div class="basic-dropdown">
        <div class="dropdown dropdown-dark">
            <button type="button" class="btn btn-sm btn-dark dropdown-toggle px-2 py-2" data-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text mr-1" viewBox="0 0 16 16">
                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a v-for="(option,index) in options" :key="index" @click.prevent="clickHandler(option)" href="javascript:;" class="dropdown-item" v-show="option.action != null">
                    {{ option.title }}
                </a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        toPdf: Function,
        toExcel: Function,
        toCsv: Function,
    },
    data(){
        return{
            options: [
                {
                    title: 'PDF',
                    action: this.toPdf,
                },
                {
                    title: 'EXCEL',
                    action: this.toExcel,
                },
                {
                    title: 'CSV',
                    action: this.toCsv,
                },
            ],
        }
    },
    methods:{
        clickHandler(option){
            if(option.action){
                option.action();
            }
            
            console.log('Export to '+option.title);
        }
    }
}
</script>