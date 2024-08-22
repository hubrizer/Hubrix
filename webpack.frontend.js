//webpack.frontend.js

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
            entries[`${pageName}${type === 'scripts' ? 'script' : 'style'}`] = entryFile;
        }
    });

    return entries;
}

module.exports = merge(common, {
    entry: {
        main: path.resolve(__dirname, 'resources/_default/frontend/src/scripts.js'),
        plugins: path.resolve(__dirname, 'resources/_default/frontend/src/plugins.js'),
        styles: path.resolve(__dirname, 'resources/_default/frontend/src/style.scss'),
        vendors: ['bootstrap/dist/css/bootstrap.min.css'],  // Add vendor CSS files here
        ...getEntries('resources/_default/frontend/src/scripts/pages', 'scripts'),
        ...getEntries('resources/_default/frontend/src/styles/pages', 'styles'),
    },
    output: {
        filename: 'js/[name].bundle.js',
        path: path.resolve(__dirname, 'public/frontend'),
        clean: true,
    },
    resolve: {
        alias: {
            '@frontend': path.resolve(__dirname, 'resources/_default/frontend/src'),
        },
    },
});
