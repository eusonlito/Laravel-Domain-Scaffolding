'use strict';

const { gulp, src, dest, series, parallel, watch } = require('gulp');

const
    autoprefixer = require('autoprefixer'),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    del = require('del'),
    env = require('gulp-environments'),
    filesExist = require('files-exist'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    merge = require('merge2'),
    postcss = require('gulp-postcss'),
    purifycss = require('gulp-purifycss'),
    replace = require('gulp-replace'),
    rev = require('gulp-rev'),
    sass = require('gulp-sass'),
    stylish = require('jshint-stylish'),
    uglify = require('gulp-uglify'),
    webpack = require('webpack-stream'),
    manifest = {};

const loadManifest = function(name) {
    if (manifest[name]) {
        return manifest[name];
    }

    let files = require(paths.from.manifest + name + '.json'),
        file = '';

    for (let key in files) {
        file = files[key].split('|');
        files[key] = paths.from[file[0]] + '' + file[1];
    }

    return manifest[name] = filesExist(files);
};

const target = './../../../public/build';

let paths = {
    from: {
        view: './../',
        scss: './scss/',
        js: './js/',
        images: './images/',
        manifest: './manifest/',
        vendor: './node_modules/'
    },

    to: {
        build: target + '/',
        css: target + '/css/',
        js: target + '/js/',
        images: target + '/images/'
    },

    directories: {
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
    let task = src(loadManifest('scss')).pipe(sass());

    if (!env.development) {
        task = task.pipe(cleancss({
            specialComments: 0,
            level: 2,
            inline: ['all']
        }));
    }

    return task
        .pipe(postcss([ autoprefixer() ]))
        .pipe(concat('main.min.css'))
        .pipe(dest(paths.to.css));
};

const jsLint = function(cb) {
    const files = loadManifest('js').filter(function(file) {
        return file.indexOf('/node_modules/') === -1;
    });

    if (files.length === 0) {
        return cb();
    }

    return src(files)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish));
};

const js = series(jsLint, function() {
    let task = src(loadManifest('js'))
        .pipe(webpack({ mode: env.development ? 'development' : 'production' }))
        .pipe(concat('main.min.js'));

    if (!env.development) {
        task = task.pipe(uglify());
    }

    return task.pipe(dest(paths.to.js));
});

const images = function() {
    let task = src(paths.from.images + '**/*');

    if (env.development) {
        return task.pipe(dest(paths.to.images));
    }

    return task.pipe(imagemin([
        imagemin.gifsicle(),
        imagemin.jpegtran(),
        imagemin.optipng(),
        imagemin.svgo({ plugins: [{ removeViewBox: false }] })
    ])).pipe(dest(paths.to.images));
};

const version = function() {
    return src(
        [
            paths.to.css + 'main.min.css',
            paths.to.js + 'main.min.js'
        ], { base: paths.to.build })
        .pipe(dest(paths.to.build))
        .pipe(rev())
        .pipe(dest(paths.to.build))
        .pipe(rev.manifest())
        .pipe(dest(paths.to.build));
};

const taskWatch = function() {
    watch(paths.from.scss + '**/*.scss', css);
    watch(paths.from.js + '**/*.js', js);
    watch(paths.from.images + '**', images);
};

exports.build = series(clean, directories, parallel(css, js, images), version);
exports.watch = series(clean, directories, parallel(css, js, images), version, taskWatch);
