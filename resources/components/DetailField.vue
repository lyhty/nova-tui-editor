<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <Viewer
                ref="viewer"
                :style="{ marginTop }"
                :dark-mode="darkMode"
                :value="field.value"
            />
        </template>
    </PanelItem>
</template>

<script>
import { Viewer } from 'tui-editor-vue3'
import { resolveNovaDarkMode, makeObserver } from '../utils/novaDarkMode'

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    components: {
        Viewer
    },
    data() {
        return {
            marginTop: null,
            darkMode: false,
            observer: null,
        }
    },
    mounted() {
        this.$nextTick(() => this.marginTop = this.grabMarginTop())

        resolveNovaDarkMode(this, 'darkMode')()
        this.observer = makeObserver(this, 'darkMode', document.documentElement)
    },
    beforeUnmount() {
        this.observer?.disconnect()
    },
    methods: {
        grabMarginTop() {
            const el = this.$refs.viewer?.$el

            if (!(el instanceof HTMLElement)) {
                return null
            }

            const child = el.querySelector('.toastui-editor-contents > *')

            if (!(child instanceof HTMLElement)) {
                return null
            }

            return '-' + window.getComputedStyle(child).getPropertyValue('margin-top')
        }
    }
}
</script>
