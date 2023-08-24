import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'

import 'tui-editor-vue3/dist/style.css'

Nova.booting((Vue: any) => {
    Vue.component('detail-nova-tui-editor', DetailField)
    Vue.component('form-nova-tui-editor', FormField)
})
