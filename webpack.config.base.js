const path = require('path');
const { VueLoaderPlugin } = require("vue-loader");
const MiniCSSExtract = require('mini-css-extract-plugin');

function webpackConfigGenerator() {
/*
    const appConfig = {
        mode: process.env.NODE_ENV,
        devtool: process.env.NODE_ENV === 'production' ? 'eval' : 'source-map',
        entry: {
            app: './resources/js/web.js'
        },
        output: {
            path: path.resolve(__dirname, 'public/dist/app'),
            filename: '[name].js',
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: ['babel-loader'],
                },
                {
                    test: /\.vue$/,
                    loader: "vue-loader",
                },
                {
                    test: /\.(scss|css)$/,
                    use: ['style-loader', 'css-loader', 'postcss-loader', 'sass-loader'],
                },
            ],
        },
        plugins: [
            new VueLoaderPlugin(),
            new MiniCSSExtract({
                filename: '[name].css',
                chunkFilename: '[id].css',
            }),
        ],
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
            },
            extensions: ["*", ".js", ".vue", ".json"],
        },
    };
*/
    const adminConfig = {
        mode: process.env.NODE_ENV,
        devtool: process.env.NODE_ENV === 'production' ? 'eval' : 'source-map',
        entry: {
            web: './resources/js/web.js',
            admin: './resources/js/admin.js'
        },
        output: {
            path: path.resolve(__dirname, 'apps/courses/public/dist'),
            filename: '[name]/app.js',
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                },
                {
                    test: /\.js$/,
                    exclude: file => (
                        /node_modules/.test(file) &&
                        !/\.vue\.js/.test(file)
                    ),
                    loader: 'babel-loader',
                },
                {
                    test: /\.(scss|css)$/,
                    use: ['style-loader', 'css-loader', 'postcss-loader', 'sass-loader'],
                },
            ],
        },
        plugins: [
            new VueLoaderPlugin(),
            new MiniCSSExtract({
                filename: '[name].css',
                chunkFilename: '[id].css',
            }),
        ],
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
            },
            extensions: ["*", ".js", ".vue", ".json"],
        },
    };

    return [
        /*appConfig,*/
        adminConfig
    ];
}

module.exports = webpackConfigGenerator;
//module.exports.parallelism = 2;
