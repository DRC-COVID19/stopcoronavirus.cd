const mix = require('laravel-mix');

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
        host: 'localhost',  // site's host name
        port: 8080,
    }
});

let LiveReloadPlugin = require('webpack-livereload-plugin');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/dashboard/vueApp.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/vueApp.scss', 'public/css');

mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ],
    resolve: {
        alias: {
            '@': path.resolve('resources/js/dashboard'),
            '@~': path.resolve('resources')
        }
    },
    devServer: { 
        proxy: {
            host: '0.0.0.0',  // host machine ip 
            port: 8080,
        },
        watchOptions:{
            aggregateTimeout:200,
            poll:5000
        },

    }
});