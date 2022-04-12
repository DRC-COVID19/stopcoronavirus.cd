const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({
  hmrOptions: {
    host: 'localhost', // site's host name
    port: 8080
  }
})

const LiveReloadPlugin = require('webpack-livereload-plugin')

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/dashboard/vueApp.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/vueApp.scss', 'public/css/vueApp.css')

mix.webpackConfig({
  plugins: [new LiveReloadPlugin()],
  resolve: {
    alias: {
      '@': path.resolve('resources/js/dashboard'),
      '@~': path.resolve('resources')
    }
  },
  devServer: {
    proxy: {
      allowedHosts: ['0.0.0.0', 'https://app.asana.com'],
      port: 8080
    },
    watchOptions: {
      aggregateTimeout: 200,
      poll: 5000
    }
  }
})
