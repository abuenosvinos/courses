const path = require('path');
const { VueLoaderPlugin } = require("vue-loader");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

/*
const webpack = require("webpack");
new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery',
});
*/

function webpackConfigGenerator() {
/*
    const appConfig = {
        mode: process.env.NODE_ENV,
        devtool: process.env.NODE_ENV === 'production' ? 'eval' : 'source-map',
        entry: {
            app: './resources/js/courses.js'
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
            courses: './resources/js/courses.js',
            admin: './resources/js/admin.js'
        },
        output: {
            path: path.resolve(__dirname, 'apps'),
            filename: '[name]/public/dist/app.js'
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
                {
                    test: /\.css$/i,
                    use: [MiniCssExtractPlugin.loader, "css-loader"],
                },
                {
                    test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[name].[ext]',
                                outputPath: 'admin/public/dist/fonts/',
                                publicPath: 'fonts/'
                            }
                        }
                    ]
                },
            ],
        },
        plugins: [
            new VueLoaderPlugin(),
            new MiniCssExtractPlugin({
                filename: '[name]/public/dist/app.css',
                chunkFilename: '[id].css',
            }),
        ],
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
                'node_modules': path.join(__dirname, 'node_modules'),
                'bower_modules': path.join(__dirname, 'bower_modules'),
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
