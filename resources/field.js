import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'

Nova.booting((Vue) => {
    Vue.component('detail-nova-tui-editor', DetailField)
    Vue.component('form-nova-tui-editor', FormField)
})
