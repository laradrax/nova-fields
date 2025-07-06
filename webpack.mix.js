const mix = require('laravel-mix')
const path = require('path')
const NovaExtension = require('laravel-nova-devtool')

mix.extend('nova', new NovaExtension())

mix
  .setPublicPath('dist')
  .alias({ '@': path.join(__dirname, 'resources/js/') })
  .js('resources/js/fields.js', 'js')
  .vue({ version: 3 })
  .nova('laradrax/nova-fields')
  .version()
