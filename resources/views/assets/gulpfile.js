'use strict';

const { gulp, src, dest, series, parallel, watch } = require('gulp');

const
    autoprefixer = require('autoprefixer'),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    del = require('del'),
    filesExist = require('files-exist'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    merge = require('merge2'),
    mode = require('gulp-mode')({ default: 'production' }),
    postcss = require('gulp-postcss'),
    purgecss = require('gulp-purgecss'),
    purifycss = require('gulp-purifycss'),
    replace = require('gulp-replace'),
    rev = require('gulp-rev'),
    sass = require('gulp-sass')(require('sass')),
    stylish = require('jshint-stylish'),
    uglify = require('gulp-uglify'),
    webpack = require('webpack-stream'),
    manifest = {};

const loadManifest = function(name, key) {
    const hash = name + '.' + key;

    if (manifest[hash]) {
        return manifest[hash];
    }

    let files = require(paths.from.manifest + name + '.json'),
        file = '';

    if (key) {
        files = files[key];
    }

    for (let index in files) {
        file = files[index].split('|');
        files[index] = paths.from[file[0]] + '' + file[1];
    }

    return manifest[hash] = filesExist(files);
};

const base = './../../../public';
const build = base + '/build';

let paths = {
    from: {
        app: './../../../app/',
        view: './../',
        html: './html/',
        scss: './scss/',
        js: './js/',
        images: './images/',
        theme: './theme/',
        manifest: './manifest/',
        vendor: './node_modules/',
        publish: './publish/'
    },

    to: {
        base: base + '/',
        build: build + '/',
        css: build + '/css/',
        js: build + '/js/',
        images: build + '/images/'
    },

    directories: {
        './fonts/**': build + '/fonts/'
    }
};

const clean = function() {
    return del(paths.to.build, { force: true });
};

const directories = function(cb) {
    for (let from in paths.directories) {
        src([from]).pipe(dest(paths.directories[from]));
    }

    cb();
};

const css = function(cb) {
    return src(loadManifest('scss'))
        .pipe(sass())
        .pipe(mode.production(
            cleancss({
                specialComments: 0,
                level: 2,
                inline: ['all']
            })
        ))
        .pipe(mode.production(
            purgecss({
                defaultExtractor: content => content.match(/[\w\.\-\/:]+(?<!:)/g) || [],
                content: [
                    paths.from.html + '/**/*.html',
                    paths.from.app + '/Services/Html/**/*.php',
                    paths.from.app + '/View/**/*.php',
                    paths.from.js + '**/*.js',
                    paths.from.view + 'domains/**/*.php',
                    paths.from.view + 'components/**/*.php',
                    paths.from.view + 'layouts/**/*.php',
                    paths.from.view + 'molecules/**/*.php',
                    paths.from.theme + '**/*.js'
                ]
            })
        ))
        .pipe(postcss([ autoprefixer() ]))
        .pipe(concat('main.min.css'))
        .pipe(dest(paths.to.css));
};

const jsLint = function(cb) {
    const files = [...loadManifest('js', 'plain'), ...loadManifest('js', 'webpack')].filter(function(file) {
        return (file.indexOf('/node_modules/') === -1)
            && (file.indexOf('/theme/') === -1);
    });

    if (files.length === 0) {
        return cb();
    }

    return src(files)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish));
};

const js = series(jsLint, function() {
    return src(loadManifest('js', 'webpack'))
        .pipe(webpack({
            mode: mode.production() ? 'production' : 'development',
            module: {
                    rules: [{
                    test: /\.svg$/,
                    use: [{
                        loader: 'html-loader',
                        options: { minimize: mode.production() ? true : false }
                    }]
                }]
            }
        }))
        .pipe(src(loadManifest('js', 'plain')))
        .pipe(concat('main.min.js'))
        .pipe(mode.production(uglify()))
        .pipe(dest(paths.to.js));
});

const images = function() {
    return src(paths.from.images + '**/*')
        .pipe(dest(paths.to.images))
        .pipe(imagemin([
            imagemin.gifsicle(),
            imagemin.mozjpeg({ progressive: true }),
            imagemin.optipng(),
            imagemin.svgo({
                plugins: [
                    { removeViewBox: false },
                    { removeEmptyAttrs: false },
                    { removeUnknownsAndDefaults: false },
                    { removeUselessStrokeAndFill: false },
                    { mergeStyles: false },
                    { mergePaths: false }
                ]
            })
        ]))
        .pipe(dest(paths.to.images));
};

const publish = function() {
    return src(paths.from.publish + '**/*')
        .pipe(dest(paths.to.build));
};

const version = function() {
    return src([
            paths.to.css + 'main.min.css',
            paths.to.js + 'main.min.js'
        ], { base: paths.to.base })
        .pipe(dest(paths.to.base))
        .pipe(rev())
        .pipe(dest(paths.to.base))
        .pipe(rev.manifest())
        .pipe(dest(paths.to.build));
};

const taskWatch = function() {
    watch(paths.from.scss + '**/*.scss', css);
    watch(paths.from.js + '**/*.js', js);
    watch(paths.from.images + '**', images);
    watch(paths.from.publish + '**', publish);
};

exports.build = series(clean, directories, parallel(css, js, images, publish), version);
exports.watch = series(clean, directories, parallel(css, js, images, publish), version, taskWatch);
