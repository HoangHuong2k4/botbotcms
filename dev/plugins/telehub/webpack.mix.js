const mix = require('laravel-mix')
const path = require('path')
const webpack = require('webpack')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/plugins/${directory}`
const dist = `public/vendor/core/plugins/${directory}`

mix.js(`${source}/resources/js/statistics.js`, `${dist}/js/statistics.js`).vue({ version: 3 })
mix.js(`${source}/resources/js/dealers.js`, `${dist}/js/dealers.js`).vue({ version: 3 })

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: 'true',
            __VUE_PROD_DEVTOOLS__: 'false',
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: 'false'
        })
    ]
})

if (mix.inProduction()) {
    mix
        .copy(`${dist}/js/statistics.js`, `${source}/public/js`)
        .copy(`${dist}/js/dealers.js`, `${source}/public/js`)
}
