const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: {
        app: path.resolve(__dirname, 'src/js/app.js')
    },
    output: {
        filename: 'js/safe/[name].safe.bundle.js',
        path: path.resolve(__dirname, 'public/assets'),
        clean: false
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                        plugins: ['@babel/plugin-transform-modules-commonjs']
                    }
                }
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/safe/[name].safe.bundle.css'
        })
    ],
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    format: {
                        comments: false
                    },
                    compress: {
                        drop_console: true,
                        drop_debugger: true
                    }
                },
                extractComments: false
            })
        ]
    },
    resolve: {
        extensions: ['.js', '.css']
    },
    devtool: 'source-map'
}; 