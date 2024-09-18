//webpack.backend.js

const { merge } = require('webpack-merge');
const path = require('path');
const fs = require('fs');
const common = require('./webpack.common.js');

function getEntries(basePath, type = 'scripts') {
    const entries = {};
    const pagesDir = path.resolve(__dirname, basePath);

    fs.readdirSync(pagesDir).forEach(pageName => {
        const pagePath = path.join(pagesDir, pageName);
        const entryFile = path.join(pagePath, `index.${type === 'scripts' ? 'js' : 'scss'}`);

        if (fs.existsSync(entryFile)) {
            entries[`${pageName}${type === 'scripts' ? 'Script' : 'Style'}`] = entryFile;
            console.log(`Added entry: ${pageName}${type === 'scripts' ? 'script' : 'style'}`);
        }
    });

    return entries;
}

module.exports = merge(common, {
    entry: {
        main: path.resolve(__dirname, 'resources/_default/backend/src/scripts.js'),
        plugins: path.resolve(__dirname, 'resources/_default/backend/src/plugins.js'),
        style: path.resolve(__dirname, 'resources/_default/backend/src/style.scss'),
        ...getEntries('resources/_default/backend/src/scripts/pages', 'scripts'),
        ...getEntries('resources/_default/backend/src/styles/pages', 'styles'),
    },
    output: {
        filename: 'js/[name].bundle.js',
        path: path.resolve(__dirname, 'public/backend'),
        clean: true,
    },
    resolve: {

        alias: {
            '@backend': path.resolve(__dirname, 'resources/_default/backend/src'),
            '@backend-mixins': path.resolve(__dirname, 'resources/_default/backend/src/scripts/mixins'),
        },
        fallback: {
            "path": require.resolve("path-browserify"),
        },
        modules: [
            path.resolve(__dirname, 'resources/_default/backend/src'),
            'node_modules',
        ],
    },
});
