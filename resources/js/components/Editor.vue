<script setup lang="ts">
import type { Ref } from 'vue'
import { ref, onMounted, watch } from 'vue'
import useEditor from '../composables/useEditor'
import { PluginName } from '../utils/plugins'
import { ToolbarItemOptions } from '@toast-ui/editor/types/ui'
import { EditorType, PreviewStyle } from '@toast-ui/editor'
import useNovaDarkMode from '../composables/useNovaDarkMode'

interface Props {
    lyhtyEnhanced?: boolean
    value: string
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
    lyhtyEnhanced: true,
    allowFullScreen: true,
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'tab',
    plugins: (): PluginName[] => [],
})

const emit = defineEmits(['input', 'add-image'])
const editor = ref(null) as Ref<HTMLDivElement | null>
const fullScreen = ref(false) as Ref<boolean>

const { darkMode, resolveNovaDarkMode, observer } = useNovaDarkMode()

watch(fullScreen, (value) => {
    const cls = document.body.classList
    value ? cls.add('overflow-hidden') : cls.remove('overflow-hidden')
})

onMounted(() => {
    resolveNovaDarkMode()
    observer(document.documentElement)

    const e = useEditor(editor as Ref<HTMLDivElement>, {
        height: '100cqh',
        hideModeSwitch: props.hideModeSwitch,
        initialEditType: props.initialEditType,
        initialValue: props.value,
        language: props.language,
        plugins: props.plugins,
        previewStyle: props.previewStyle,
        toolbarItems: props.toolbarItems,
        usageStatistics: props.usageStatistics,
        useCommandShortcut: props.useCommandShortcut,
        addImageBlobHook: (blob, callback): void => emit('add-image', { blob, callback }),
        onChange: (e): void => emit('input', e.getMarkdown()),
    })
})
</script>

<template>
    <div
        class="nova-toastui"
        :style="{ height: !fullScreen ? height : undefined }"
        @keydown.escape="fullScreen = false"
        :class="{
            'lyhty-enhanced': lyhtyEnhanced,
            'toastui-full-screen': fullScreen,
            'toastui-editor-dark': darkMode
        }"
    >
        <div
            ref="editor"
            :class="{ 'form-input form-input-bordered': !fullScreen }"
        />
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
