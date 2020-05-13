const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const babel = require('gulp-babel');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const minifyCSS = require('gulp-uglifycss');
const minifyJS = require('gulp-uglify');

const onError = err => console.log(err);

const paths = {
  public: {
    scss: {
      src: './src/scss/mpcr-todo-public.scss',
      dest: './public/css/',
    },
    js: {
      src: './src/js/mpcr-todo-public.js',
      dest: './public/js/',
    },
  },
  admin: {
    scss: {
      src: './src/scss/mpcr-todo-admin.scss',
      dest: './admin/css/',
    },
    js: {
      src: './src/js/mpcr-todo-admin.js',
      dest: './admin/js/',
    },
  },
};

const stylePublic = () =>
  gulp
    .src(paths.public.scss.src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sass().on('error', onError))
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest(paths.public.scss.dest));

const styleAdmin = () =>
  gulp
    .src(paths.admin.scss.src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sass().on('error', onError))
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest(paths.admin.scss.dest));

const jsPublic = () =>
  gulp
    .src(paths.public.js.src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(babel())
    .pipe(minifyJS())
    .pipe(gulp.dest(paths.public.js.dest));

const jsAdmin = () =>
  gulp
    .src(paths.admin.js.src)
    .pipe(plumber({ errorHandler: onError }))
    .pipe(babel())
    .pipe(minifyJS())
    .pipe(gulp.dest(paths.admin.js.dest));

const watcher = () => {
  gulp.watch('./src/scss/base/**/*.scss', gulp.series(stylePublic, styleAdmin));
  gulp.watch(['./src/scss/admin/**/*.scss', paths.admin.scss.src], styleAdmin);
  gulp.watch(
    ['./src/scss/public/**/*.scss', paths.public.scss.src],
    stylePublic
  );

  gulp.watch(paths.admin.js.src, jsAdmin);
  gulp.watch(paths.public.js.src, jsPublic);
};

const styleWatcher = gulp.series(
  stylePublic,
  styleAdmin,
  jsPublic,
  jsAdmin,
  watcher
);

exports.default = styleWatcher;
