<script setup lang="ts">
import { Ref, onMounted, ref } from 'vue'
import { PluginName } from '../utils/plugins'
import useViewer from '../composables/useViewer'
import useNovaDarkMode from '../composables/useNovaDarkMode';

const props = withDefaults(defineProps<{
    value: string
    plugins?: PluginName[]
}>(), {
    plugins: (): PluginName[] => [],
})

const viewer = ref(null) as Ref<HTMLDivElement | null>
const { darkMode, resolveNovaDarkMode, observer } = useNovaDarkMode()

onMounted(() => {
    resolveNovaDarkMode()
    observer(document.documentElement)

    useViewer(viewer, {
        initialValue: props.value,
        plugins: props.plugins,
    })
})
</script>

<template>
    <div
        :class="{ 'toastui-editor-dark': darkMode }"
        ref="viewer"
    />
</template>
