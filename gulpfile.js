const { src, dest, watch, series } = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const cleanCSS = require('gulp-clean-css');
const babel = require('gulp-babel');
const xss = require('gulp-xss');

// Konfigurasi path
const paths = {
    js: {
        src: [
            'src/js/vendor/*.js',
            'src/js/custom/*.js',
            'src/js/app.js'
        ],
        dest: 'public/assets/js/safe'
    },
    css: {
        src: [
            'src/css/vendor/*.css',
            'src/css/custom/*.css'
        ],
        dest: 'public/assets/css/safe'
    }
};

// Task untuk JavaScript
function javascript() {
    return src(paths.js.src, { sourcemaps: true })
        .pipe(babel({
            presets: ['@babel/env'],
            plugins: ['@babel/plugin-transform-modules-commonjs']
        }))
        .pipe(concat('app.safe.bundle.js'))
        .pipe(xss()) // XSS protection
        .pipe(uglify({
            compress: {
                drop_console: true,
                drop_debugger: true
            }
        }))
        .pipe(dest(paths.js.dest, { sourcemaps: '.' }));
}

// Task untuk CSS
function styles() {
    return src(paths.css.src, { sourcemaps: true })
        .pipe(concat('app.safe.bundle.css'))
        .pipe(cleanCSS({
            level: 2,
            compatibility: 'ie11'
        }))
        .pipe(dest(paths.css.dest, { sourcemaps: '.' }));
}

// Watch task
function watchFiles() {
    watch(paths.js.src, javascript);
    watch(paths.css.src, styles);
}

// Export tasks
exports.javascript = javascript;
exports.styles = styles;
exports.watch = watchFiles;

// Default task
exports.default = series(javascript, styles, watchFiles); 