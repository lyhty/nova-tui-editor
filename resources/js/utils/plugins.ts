import chart from '@toast-ui/editor-plugin-chart'
import codeSyntaxHighlight from '@toast-ui/editor-plugin-code-syntax-highlight'
import colorSyntax from '@toast-ui/editor-plugin-color-syntax'
import tableMergedCell from '@toast-ui/editor-plugin-table-merged-cell'
import uml from '@toast-ui/editor-plugin-uml'

export type PluginName = 'chart' | 'codeSyntaxHighlight' | 'colorSyntax' | 'tableMergedCell' | 'uml'

type MapPlugins = (plugins: string[]) => any[]
export const mapPlugins: MapPlugins = (plugins: string[]) => {
    const pluginMap: { [key: string]: any } = {
        chart,
        codeSyntaxHighlight,
        colorSyntax,
        tableMergedCell,
        uml
    }

    return plugins.map((plugin) => pluginMap[plugin])
}
