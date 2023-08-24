<script setup lang="ts">
import { Ref, onMounted, ref } from 'vue'
import { PluginName } from '../utils/plugins'
import useViewer from '../composables/useViewer'

const props = withDefaults(defineProps<{
    value: string
    plugins?: PluginName[]
    darkMode?: boolean
}>(), {
    plugins: (): PluginName[] => [],
    darkMode: false
})

const viewer = ref(null) as Ref<HTMLDivElement | null>

onMounted(() => {
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
