const mix = require("laravel-mix");
const path = require("path");

const directory = path.basename(path.resolve(__dirname));
const source = `dev/ui/${directory}`;
const dist = `public/ui/${directory}`;

// Cấu hình TypeScript cho React
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                include: /assets\/react/,
                use: [
                    {
                        loader: "babel-loader",
                        options: {
                            presets: [
                                "@babel/preset-env",
                                "@babel/preset-typescript",
                                "@babel/preset-react",
                            ],
                        },
                    },
                ],
                exclude: /node_modules/,
            },
        ],
    },
    resolve: {
        extensions: [".tsx", ".ts", ".js", ".jsx"],
    },
    externals: {
        // Không externalize React để có thể bundle
    },
});

mix.sass(`${source}/assets/sass/style.scss`, `${dist}/css`)
    .js(`${source}/assets/js/master.js`, `${dist}/js`)
// .js(`${source}/assets/react/app.tsx`, `${dist}/js`) // Build React TypeScript
// .copy(source + "/assets/fonts", dist + "/fonts")
// .copy(source + "/assets/images", dist + "/images")
// .copy(source + "/assets/media", dist + "/media")

if (mix.inProduction()) {
    mix.copy(`${dist}/css/style.css`, `${source}/public/css`)
        .copy(`${dist}/js/master.js`, `${source}/public/js`)
    // .copy(`${dist}/js/app.js`, `${source}/public/js`)
    // .copy(`${dist}/fonts`, `${source}/public/fonts`)
    // .copy(`${dist}/images`, `${source}/public/images`)
    // .copy(`${dist}/media`, `${source}/public/media`);
}
