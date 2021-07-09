const path = require('path');

const appConfig = {
    mode: process.env.NODE_ENV ? 'development' : 'production',
    entry: {
        app: './resources/js/app.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/dist/app'),
        filename: '[name].js',
    }
};

const adminConfig = {
    mode: process.env.NODE_ENV ? 'development' : 'production',
    entry: {
        app: './resources/js/admin.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/dist/admin'),
        filename: '[name].js',
    },
};

module.exports = [
    appConfig,
    adminConfig
];