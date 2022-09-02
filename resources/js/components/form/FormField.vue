<template>
    <form @submit.prevent="submit">
        <div class="alert alert-danger" v-if="errorMessage" v-html="errorMessage"></div>
        <slot />
    </form>
</template>
<script>
export default {
    props:{
        id: {
            type: String,
            required: true,
        },
        validation: Function,
        onSubmit: Function,
    },
    data(){
        return{
            away: true,
            errorMessage: null,
        }
    },
    computed:{
        isAway(){
            return this.away;
        },
    },
    methods:{
        validationHandler(){
            return new Promise(
                async (resolve, reject) => {
                    var result = true;
                    
                    for(var x in this.$children){
                        if(this.$children[x].validationHandler instanceof Function){
                            result = await this.$children[x].validationHandler();
                        }
                        if(!result) reject(result)
                    }
                    
                    if(this.validation){
                        result = await this.validation();
                    }

                    resolve(true);

                }
            )
        },
        submit(){
            if(this.away){
                this.away = false;
                this.validationHandler()
                    .then(async (resp) => {
                        if(this.onSubmit){
                            await this.onSubmit();
                        }
                    })
                    .catch(err => {
                        console.error('Form validation is error.');
                    })
                    .then(resp => {
                        this.away = true;
                    })
            }
        },
        setError(message){
            if(message){
                this.errorMessage = message;
            }else{
                this.errorMessage = null;
            }
        },
        clearError(){
            this.errorMessage = null;
            for(var x in this.$children){
                if(this.$children[x].clearInvalid instanceof Function){
                    this.$children[x].clearInvalid()
                }
            }
        },
    },
    created(){
        this.$form.components.push(this);
    },
    destroyed(){
        const index = this.$form.components.findIndex((component) => component.id === this.id);
        if(index !== -1){
            this.$el.remove();
            this.$form.components.splice(index, 1);
        }
    }
}
</script>