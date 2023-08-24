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
                :model-value="value"
                :enhanced="field.enhanced"
                :editor-classes="{ 'form-input form-input-bordered': !fullScreen }"
                v-bind="field.editor"
                :dark-mode="darkMode"
                @update:model-value="handleChange"
                @add-image="handleFileAdded"
                @full-screen-change="fullScreen = $event"
            />
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors, HandlesFieldAttachments } from 'laravel-nova'
import { resolveNovaDarkMode, makeObserver } from '../utils/novaDarkMode'
import { Editor } from 'tui-editor-vue3'

export default {
    emits: ['field-changed'],

    mixins: [HandlesValidationErrors, HandlesFieldAttachments, FormField],

    data() {
        return {
            value: '',
            fullScreen: false,
            darkMode: false,
            observer: null,
        }
    },

    components: {
        Editor
    },

    mounted() {
        Nova.$on(this.fieldAttributeValueEventName, this.listenToValueChanges)

        resolveNovaDarkMode(this, 'darkMode')()
        this.observer = makeObserver(this, 'darkMode', document.documentElement)
    },

    beforeUnmount() {
        Nova.$off(this.fieldAttributeValueEventName, this.listenToValueChanges)

        this.clearAttachments()
        this.observer?.disconnect()
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
