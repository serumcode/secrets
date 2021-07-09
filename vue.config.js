
const path = require('path');

module.exports = {
  transpileDependencies: [
    'vuetify'
  ],
  devServer: {
    public: process.env.VUE_APP_LOCALHOST,
    host: '0.0.0.0',
    disableHostCheck: true
  },
  lintOnSave: false,
  pluginOptions: {
    'style-resources-loader': {
      preProcessor: 'scss',
      patterns: [path.resolve(__dirname, './src/styles/app.scss')]
    },
  },
  chainWebpack: config => {
    config
      .output.chunkFilename('[chunkhash].bundle.js').end()
      .optimization.splitChunks({
        cacheGroups: {
          vendorStyles: {
            name: 'vendor',
            test(module) {
              return (
                (/node_modules/).test(module.context) &&
                // do not externalize if the request is a CSS file
                !(/\.css$/).test(module.request)
              );
            },
            chunks: 'all',
            enforce: true
          }
        }
      }
    );
 
}
};
