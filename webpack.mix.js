let mix = require('laravel-mix')

mix
    .setPublicPath('dist')
    .ts('resources/entry.ts', 'js')
    .vue({ version: 3 })
    .webpackConfig({
        resolve: {
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"]
        },
        stats: {
            children: true,
        },
        externals: {
            vue: 'Vue',
            'laravel-nova': 'LaravelNova',
        },
        output: {
            uniqueName: 'lyhty/nova-tui-editor',
        }
    });
