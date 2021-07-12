const path = require('path');

const appConfig = {
    mode: process.env.NODE_ENV,
    devtool: process.env.NODE_ENV === 'production' ? 'source-map' : 'eval',
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
        ],
    },
};

const adminConfig = {
    mode: process.env.NODE_ENV,
    devtool: process.env.NODE_ENV === 'production' ? 'source-map' : 'eval',
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
        ],
    },
};

module.exports = [
    appConfig,
    adminConfig
];
module.exports.parallelism = 2;