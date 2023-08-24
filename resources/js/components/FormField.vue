<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :full-width-content="fullWidthContent"
        :key="index"
        :show-help-text="showHelpText"
      >
        <template #field>
            <!-- @vue-ignore -->
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

<script lang="ts">
// @ts-ignore
import { FormField, HandlesValidationErrors, HandlesFieldAttachments } from 'laravel-nova'
import { resolveNovaDarkMode, makeObserver } from '../utils/novaDarkMode'
import Editor from './Editor.vue'

interface Data {
    value: any
    fullScreen: boolean
    darkMode: boolean
    observer: MutationObserver | null
}

export default {
    emits: ['field-changed'],

    mixins: [HandlesValidationErrors, HandlesFieldAttachments, FormField],

    data() {
        return <Data>{
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
        decodeEntities(value: any): any {
            value = value.replace(/%7B/g, '{');
            value = value.replace(/%7D/g, '}');
            return value;
        },

        setInitialValue(): void {
            this.value = this.decodedFieldValue;
        },

        fill(formData: any): void {
            this.fillIfVisible(formData, this.fieldAttribute, this.value || '')
            this.fillAttachmentDraftId(formData)
        },

        handleChange(value: any): void {
            this.value = value;
        },

        handleFileAdded({ blob, callback }: { blob: any, callback: any }): void {
            this.uploadAttachment(blob, { onCompleted: callback })
        },
    },
}
</script>
