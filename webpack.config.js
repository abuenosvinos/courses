const { merge } = require('webpack-merge');
const baseConfigGenerator = require('./webpack.config.base.js');
const prodConfig = require('./webpack.config.prod.js');
const devConfig = require('./webpack.config.dev.js');

function webpackEnviromentSelector() {
    let configEnv =  (process.env.NODE_ENV === 'production') ? prodConfig : devConfig;
    const baseConfig = baseConfigGenerator();
    for (let conf of baseConfig) {
        conf = merge(conf, configEnv);
    }
    return baseConfig;
}

module.exports = webpackEnviromentSelector;
