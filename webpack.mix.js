let mix = require('laravel-mix')
require('./nova.mix')

mix
    .setPublicPath('dist')
    .js('resources/field.js', 'js')
    .css('resources/field.css', 'css')
    .vue({ version: 3 })
    .nova('lyhty/nova-tui-editor')
