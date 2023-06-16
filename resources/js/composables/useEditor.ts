import '@toast-ui/editor/dist/i18n/ar'
import '@toast-ui/editor/dist/i18n/cs-cz'
import '@toast-ui/editor/dist/i18n/de-de'
import '@toast-ui/editor/dist/i18n/es-es'
import '@toast-ui/editor/dist/i18n/fi-fi'
import '@toast-ui/editor/dist/i18n/fr-fr'
import '@toast-ui/editor/dist/i18n/gl-es'
import '@toast-ui/editor/dist/i18n/it-it'
import '@toast-ui/editor/dist/i18n/ja-jp'
import '@toast-ui/editor/dist/i18n/ko-kr'
import '@toast-ui/editor/dist/i18n/nb-no'
import '@toast-ui/editor/dist/i18n/nl-nl'
import '@toast-ui/editor/dist/i18n/pl-pl'
import '@toast-ui/editor/dist/i18n/ru-ru'
import '@toast-ui/editor/dist/i18n/sv-se'
import '@toast-ui/editor/dist/i18n/tr-tr'
import '@toast-ui/editor/dist/i18n/uk-ua'
import '@toast-ui/editor/dist/i18n/zh-cn'
import '@toast-ui/editor/dist/i18n/zh-tw'
import '@toast-ui/editor/dist/i18n/zh-tw'

import { Ref } from 'vue'
import Editor, { EditorType, PreviewStyle } from '@toast-ui/editor'
import { ToolbarItemOptions } from '@toast-ui/editor/types/ui'
import { PluginName, mapPlugins } from '../utils/plugins'

export type HookCallback = (url: string, text?: string) => void
export type AddImageBlobHook = (blob: Blob | File, callback: HookCallback) => void

interface Options {
    initialValue: string

    height?: string
    hideModeSwitch?: boolean
    initialEditType?: EditorType
    language?: string
    plugins?: PluginName[]
    previewStyle?: PreviewStyle
    toolbarItems?: (string | ToolbarItemOptions)[][]
    usageStatistics?: boolean
    useCommandShortcut?: boolean

    onChange?: (e: Editor) => void
    addImageBlobHook?: AddImageBlobHook
}

export default (elRef: Ref<HTMLElement>, options: Options) => {
    const e: Editor = new Editor({
        el: elRef.value,

        height: options.height,
        hideModeSwitch: options.hideModeSwitch,
        initialEditType: options.initialEditType,
        initialValue: options.initialValue,
        language: options.language,
        plugins: options.plugins !== undefined
            ? mapPlugins(options.plugins)
            : undefined,
        previewStyle: options.previewStyle,
        toolbarItems: options.toolbarItems,
        usageStatistics: options.usageStatistics,
        useCommandShortcut: options.useCommandShortcut,

        events: {
            change: options.onChange
                ? () => options.onChange(e)
                : () => {},
        },
        hooks: {
            addImageBlobHook: options.addImageBlobHook,
        }
    })

    return e
}


