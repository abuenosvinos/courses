const path = require('path');

const appConfig = {
    entry: {
        app: './resources/js/app.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/dist/app'),
        filename: '[name].js',
    },
};

const adminConfig = {
    entry: {
        app: './resources/js/admin.js'
    },
    output: {
        path: path.resolve(__dirname, 'public/dist/admin'),
        filename: '[name].js',
    },
};

module.exports = [appConfig, adminConfig];