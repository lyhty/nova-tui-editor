<script setup lang="ts">
import type { Ref } from 'vue'
import { ref, onMounted } from 'vue'
import useEditor, { AddImageBlobHook, PluginName } from '../composables/useEditor'

interface Props {
    value: string
    addImageBlobHook?: AddImageBlobHook
    height?: string
    plugins?: PluginName[]
    initialEditType?: 'markdown' | 'wysiwyg'
    previewStyle?: 'vertical' | 'tab'
}

const props = withDefaults(defineProps<Props>(), {
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'tab',
    plugins: () => [],
})

const emit = defineEmits(['input'])
const editor = ref(null) as Ref<HTMLDivElement | null>
const fullScreen = ref(false) as Ref<boolean>
const darkMode = ref(false) as Ref<boolean>

const resolveNovaDarkMode = () => {
    const cls = document.documentElement.classList
    const novaDarkModeEnabled = cls.contains('dark')

    if (novaDarkModeEnabled && !darkMode.value) {
        darkMode.value = true
    } else if (!novaDarkModeEnabled && darkMode.value) {
        darkMode.value = false
    }
}

onMounted(() => {
    resolveNovaDarkMode()

    new MutationObserver(resolveNovaDarkMode)
        .observe(document.documentElement, {
            attributes: true,
            attributeOldValue: true,
            attributeFilter: ['class'],
        })

    const e = useEditor(editor as Ref<HTMLDivElement>, {
        height: '100cqh',
        initialValue: props.value,
        initialEditType: props.initialEditType,
        plugins: props.plugins,
        previewStyle: props.previewStyle,
        addImageBlobHook: props.addImageBlobHook,
        onChange: (e) => emit('input', e.getMarkdown()),
    })
})
</script>

<template>
    <div
        class="nova-toastui"
        :style="{ height: !fullScreen ? height : undefined }"
        :class="{
            'relative': !fullScreen,
            'fixed inset-0 z-50': fullScreen,
            'toastui-editor-dark': darkMode
        }"
    >
        <div
            ref="editor"
            class="form-input form-input-bordered "
        />
        <div class="fullscreen-button-container">
            <a href="#" class="fullscreen-button" @click.prevent="fullScreen = !fullScreen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
            </a>
        </div>
    </div>
</template>
