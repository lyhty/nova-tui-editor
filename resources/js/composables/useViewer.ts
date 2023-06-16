import Viewer from '@toast-ui/editor/dist/toastui-editor-viewer'
import { Ref } from 'vue'
import { PluginName, mapPlugins } from '../utils/plugins'

interface Options {
    initialValue?: string

    plugins?: PluginName[];
    // extendedAutolinks?: ExtendedAutolinks;
    // linkAttributes?: LinkAttributes;
    // referenceDefinition?: boolean;
    // frontMatter?: boolean;
    // usageStatistics?: boolean;
    // theme?: string;
}

export default (elRef: Ref<HTMLElement>, options: Options) => {
    const e: Viewer = new Viewer({
        el: elRef.value,
        plugins: options.plugins !== undefined
            ? mapPlugins(options.plugins)
            : undefined,
        initialValue: options.initialValue,
    })

    return e
}
