require('./style.scss')
import FormField from './FormField.vue'
import InputField from './InputField.vue'
import InputSubmit from './InputSubmit.vue'
import InputSelect from './InputSelect.vue'
import TextAreaField from './TextAreaField.vue'
import InputDate from './InputDate.vue'
import InputTime from './InputTime.vue'
import InputImage from './InputImage.vue'
import InputColorPicker from './InputColorPicker.vue'
import SwitchButton from './SwitchButton.vue'
import InputFile from './InputFile.vue'

const FormInputPlugin = {
    // eslint-disable-next-line no-unused-vars
    install(Vue, options) {
        Vue.component('FormField', FormField)
        Vue.component('InputField', InputField)
        Vue.component('InputSubmit', InputSubmit)
        Vue.component('InputSelect', InputSelect)
        Vue.component('TextAreaField', TextAreaField)
        Vue.component('InputDate', InputDate)
        Vue.component('InputTime', InputTime)
        Vue.component('InputImage', InputImage)
        Vue.component('InputColorPicker', InputColorPicker)
        Vue.component('SwitchButton', SwitchButton)
        Vue.component('InputFile', InputFile)

        Vue.prototype.$form = {
            components: [],
            setError(id,message){
                var component = _.find(this.components, {id:id});
                if(component) component.setError(message);
            },
            clearError(id){
                var component = _.find(this.components, {id:id});
                if(component) component.clearError();
            },
            submit(id){
                var component = _.find(this.components, {id:id});
                if(component) component.submit();
            },
        }
    }
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(FormInputPlugin)
}

export {
    FormField,
    InputField,
    InputSubmit,
    TextAreaField,
    InputDate,
    InputTime,
    InputImage,
    InputFile,
}

export default FormInputPlugin
