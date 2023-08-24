export const makeObserver = (ctx: any, attribute: string, element: HTMLElement) => {
    const observer = new MutationObserver(resolveNovaDarkMode(ctx, attribute))
    observer.observe(element, {
        attributes: true,
        attributeOldValue: true,
        attributeFilter: ['class'],
    })

    return observer
}

export const resolveNovaDarkMode = (ctx: any, attribute: string) => () => {
    const cls = document.documentElement.classList
    const novaDarkModeEnabled = cls.contains('dark')

    if (novaDarkModeEnabled && !ctx[attribute]) {
        ctx[attribute] = true
    } else if (!novaDarkModeEnabled && ctx[attribute]) {
        ctx[attribute] = false
    }
}
