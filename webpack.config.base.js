const path = require('path');
const MiniCSSExtract = require('mini-css-extract-plugin');

function webpackConfigGenerator() {

    const appConfig = {
        mode: process.env.NODE_ENV,
        devtool: process.env.NODE_ENV === 'production' ? 'eval' : 'source-map',
        entry: {
            app: './resources/js/app.js'
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
                    test: /\.(scss|css)$/,
                    use: ['style-loader', 'css-loader', 'postcss-loader', 'sass-loader'],
                },
            ],
        },
        plugins: [
            new MiniCSSExtract({
                filename: '[name].css',
                chunkFilename: '[id].css',
            }),
        ],
    };

    const adminConfig = {
        mode: process.env.NODE_ENV,
        devtool: process.env.NODE_ENV === 'production' ? 'eval' : 'source-map',
        entry: {
            app: './resources/js/admin.js'
        },
        output: {
            path: path.resolve(__dirname, 'public/dist/admin'),
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
                    test: /\.(scss|css)$/,
                    use: ['style-loader', 'css-loader', 'postcss-loader', 'sass-loader'],
                },
            ],
        },
        plugins: [
            new MiniCSSExtract({
                filename: '[name].css',
                chunkFilename: '[id].css',
            }),
        ],
    };

    return [
        appConfig,
        adminConfig
    ];
}

module.exports = webpackConfigGenerator;
//module.exports.parallelism = 2;
