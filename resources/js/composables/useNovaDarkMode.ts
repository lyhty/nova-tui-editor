import { Ref, ref } from "vue"

export default () => {
    const darkMode: Ref<boolean> = ref(false)

    const resolveNovaDarkMode = (): void => {
        const cls = document.documentElement.classList
        const novaDarkModeEnabled = cls.contains('dark')

        if (novaDarkModeEnabled && !darkMode.value) {
            darkMode.value = true
        } else if (!novaDarkModeEnabled && darkMode.value) {
            darkMode.value = false
        }
    }

    return {
        darkMode,
        resolveNovaDarkMode,
        observer: (element: HTMLElement) => new MutationObserver(resolveNovaDarkMode)
            .observe(element, {
                attributes: true,
                attributeOldValue: true,
                attributeFilter: ['class'],
            })
    }
}
