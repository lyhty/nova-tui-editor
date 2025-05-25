export const makeObserver = (ctx, attribute, element) => {
    const observer = new MutationObserver(resolveNovaDarkMode(ctx, attribute))
    observer.observe(element, {
        attributes: true,
        attributeOldValue: true,
        attributeFilter: ['class'],
    })

    return observer
}

export const resolveNovaDarkMode = (ctx, attribute) => () => {
    const cls = document.documentElement.classList
    const novaDarkModeEnabled = cls.contains('dark')

    if (novaDarkModeEnabled && !ctx[attribute]) {
        ctx[attribute] = true
    } else if (!novaDarkModeEnabled && ctx[attribute]) {
        ctx[attribute] = false
    }
}
