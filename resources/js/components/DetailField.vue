<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <Viewer
                ref="viewer"
                :style="{ marginTop }"
                :value="field.value"
            />
        </template>
    </PanelItem>
</template>

<script>
import Viewer from './Viewer.vue'

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    components: {
        Viewer
    },
    data() {
        return {
            marginTop: null
        }
    },
    mounted() {
        this.$nextTick(() => this.marginTop = this.grabMarginTop())
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

            return '-' + window.getComputedStyle(child)['margin-top']
        }
    }
}
</script>
