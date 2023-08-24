<script setup lang="ts">
import type { Ref } from 'vue'
import { ref, onMounted, watch } from 'vue'
import useEditor from '../composables/useEditor'
import { PluginName } from '../utils/plugins'
import { ToolbarItemOptions } from '@toast-ui/editor/types/ui'
import { EditorType, PreviewStyle } from '@toast-ui/editor'

interface Props {
    enhanced?: boolean
    editorClasses: object | string | string[]
    darkMode?: boolean
    modelValue: string
    allowFullScreen?: boolean
    height?: string
    hideModeSwitch?: boolean
    initialEditType?: EditorType
    language?: string
    plugins?: PluginName[]
    previewStyle?: PreviewStyle
    toolbarItems?: (string | ToolbarItemOptions)[][]
    usageStatistics?: boolean
    useCommandShortcut?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    enhanced: true,
    darkMode: false,
    allowFullScreen: true,
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'tab',
    plugins: (): PluginName[] => [],
})

const emit = defineEmits(['update:modelValue', 'addImage', 'fullScreenChange'])
const editor = ref(null) as Ref<HTMLDivElement | null>
const fullScreen = ref(false) as Ref<boolean>

watch(fullScreen, (value) => {
    const cls = document.body.classList
    value ? cls.add('overflow-hidden') : cls.remove('overflow-hidden')

    emit('fullScreenChange', value)
})

onMounted(() => {
    const e = useEditor(editor as Ref<HTMLDivElement>, {
        height: '100cqh',
        hideModeSwitch: props.hideModeSwitch,
        initialEditType: props.initialEditType,
        initialValue: props.modelValue,
        language: props.language,
        plugins: props.plugins,
        previewStyle: props.previewStyle,
        toolbarItems: props.toolbarItems,
        usageStatistics: props.usageStatistics,
        useCommandShortcut: props.useCommandShortcut,
        addImageBlobHook: (blob, callback): void => emit('addImage', { blob, callback }),
        onChange: (e): void => emit('update:modelValue', e.getMarkdown()),
    })
})
</script>

<template>
    <div
        class="tui-editor-vue3-wrapper"
        :style="{ height: !fullScreen ? height : undefined }"
        @keydown.escape="fullScreen = false"
        :class="{
            'tui-editor-vue3-enhanced': enhanced,
            'toastui-full-screen': fullScreen,
            'toastui-editor-dark': darkMode
        }"
    >
        <div ref="editor" :class="editorClasses" />
        <div
            class="fullscreen-button-container"
            v-if="props.allowFullScreen"
        >
            <a href="#" class="fullscreen-button" @click.prevent="fullScreen = !fullScreen">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
            </a>
        </div>
    </div>
</template>
