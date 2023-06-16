<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :full-width-content="fullWidthContent"
        :key="index"
        :show-help-text="showHelpText"
      >
        <template #field>
            <Editor
                ref="toastUiEditor"
                :value="value"
                @input="handleChange"
            />
        </template>
    </DefaultField>
</template>

<script>
import Editor from './Editor.vue'
import { FormField, HandlesValidationErrors, HandlesFieldAttachments } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors, HandlesFieldAttachments],
    components: {
        Editor
    },
    computed: {
        decodedFieldValue() {
            return this.decodeEntities(this.field.value ?? '');
        },
    },
    methods: {
        decodeEntities(value) {
            value = value.replace(/%7B/g, '{');
            value = value.replace(/%7D/g, '}');
            return value;
        },

        setInitialValue() {
            this.value = this.decodedFieldValue;
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
        },

        handleChange(value) {
            this.value = value;
        },
    },
}
</script>
