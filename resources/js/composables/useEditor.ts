import { Ref } from 'vue'
import Editor from '@toast-ui/editor'

import chart from '@toast-ui/editor-plugin-chart'
import codeSyntaxHighlight from '@toast-ui/editor-plugin-code-syntax-highlight'
import colorSyntax from '@toast-ui/editor-plugin-color-syntax'
import tableMergedCell from '@toast-ui/editor-plugin-table-merged-cell'
import uml from '@toast-ui/editor-plugin-uml'

export type HookCallback = (url: string, text?: string) => void
export type AddImageBlobHook = (blob: Blob | File, callback: HookCallback) => void
export type PluginName = 'chart' | 'codeSyntaxHighlight' | 'colorSyntax' | 'tableMergedCell' | 'uml'

interface Options {
    addImageBlobHook?: AddImageBlobHook
    height: string
    initialValue: string
    initialEditType: 'markdown' | 'wysiwyg'
    plugins?: PluginName[]
    previewStyle: 'tab' | 'vertical'
    onChange: (e: Editor) => void
}

export default (elRef: Ref<HTMLElement>, options: Options) => {
    const e: Editor = new Editor({
        el: elRef.value,
        height: options.height,
        plugins: mapPlugins(options.plugins),
        initialEditType: options.initialEditType,
        previewStyle: options.previewStyle,
        initialValue: options.initialValue,
        events: {
            change: () => options.onChange(e)
        },
        hooks: {
            addImageBlobHook: options.addImageBlobHook,
        }
    })

    return e
}

type MapPlugins = (plugins: string[]) => any[]
const mapPlugins: MapPlugins = (plugins: string[]) => {
    const pluginMap: { [key: string]: any } = {
        chart,
        codeSyntaxHighlight,
        colorSyntax,
        tableMergedCell,
        uml
    }

    return plugins.map((plugin) => pluginMap[plugin])
}
