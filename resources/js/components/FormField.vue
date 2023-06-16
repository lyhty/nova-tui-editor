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
                :lyhty-enhanced="field.lyhtyEnhanced"
                v-bind="field.editor"
                @input="handleChange"
                @add-image="handleFileAdded"
            />
        </template>
    </DefaultField>
</template>

<script>
import Editor from './Editor.vue'
import { FormField, HandlesValidationErrors, HandlesFieldAttachments } from 'laravel-nova'

export default {
    emits: ['field-changed'],

    mixins: [HandlesValidationErrors, HandlesFieldAttachments, FormField],

    components: {
        Editor
    },

    mounted() {
        Nova.$on(this.fieldAttributeValueEventName, this.listenToValueChanges)
    },

    beforeUnmount() {
        Nova.$off(this.fieldAttributeValueEventName, this.listenToValueChanges)

        this.clearAttachments()
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
            this.fillIfVisible(formData, this.fieldAttribute, this.value || '')
            this.fillAttachmentDraftId(formData)
        },

        handleChange(value) {
            this.value = value;
        },

        handleFileAdded({ blob, callback }) {
            this.uploadAttachment(blob, { onCompleted: callback })
        },
    },
}
</script>
