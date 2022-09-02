import Swal from 'sweetalert2'

export default {
    install(Vue, options){

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Vue.prototype.$toast = {
            success(message){
                Toast.fire({
                    icon: 'success',
                    title: message
                })
            },
            error(message){
                Toast.fire({
                    icon: 'error',
                    title: message
                })
            },
            info(message){
                Toast.fire({
                    icon: 'info',
                    title: message
                })
            },
            warning(message){
                Toast.fire({
                    icon: 'warning',
                    title: message
                })
            }
        }
    }
}
