<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            {{ field.value }}
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    components: {
        //
    }
}
</script>
