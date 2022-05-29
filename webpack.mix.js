const mix = require("laravel-mix");
const LiveReloadPlugin = require("webpack-livereload-plugin");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/audio.js", "public/js")
    .js("resources/js/player.js", "public/js")
    .js("resources/js/sampler.js", "public/js")
    .js("resources/js/polyfill.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .webpackConfig({
        plugins: [
            new LiveReloadPlugin({
                ignore: /(node_modules)|(vendor)/,
                // https://github.com/livereload/livereload-js/blob/master/src/options.js
                ext: "js,css,php",
            }),
        ],
        watchOptions: {
            // https://webpack.js.org/configuration/watch/#watchoptionsignored
            ignored: /(node_modules)|(vendor)/,
            // https://webpack.js.org/configuration/watch/#watchoptionspoll
            poll: 1000,
        },
    });
