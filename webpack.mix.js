let mix = require('webpack-mix');

// mix.config.fileLoaderDirs.fonts = 'public/css/fonts';

// mix.autoload({
//     jquery: ['$', 'window.jQuery'],
// });

mix.js('src/js/app.js', 'public/js')
    .sass('src/scss/app.scss', 'public/css').sourceMaps();

// mix.js([
//     'src/js/libs/*',
//     'node_modules/@popperjs/core/dist/umd/popper.min.js',
//     'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
// ], 'public/js/libs/libs.js');
