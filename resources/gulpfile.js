const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat-css');
const browserSync = require('browser-sync').create();

// function runSass() {
//   return gulp
//     .src('sass/**.scss')
//     .pipe(sass())
//     // .pipe(concat('staff.css'))
//     .pipe(gulp.dest('../../public/stylesheets/'))
//     .pipe(browserSync.stream());
// }

function runStaffSass() {
  return gulp
    .src('sass/staff/*.scss')
    .pipe(sass())
    .pipe(concat('staff.css'))
    .pipe(gulp.dest('../public/stylesheets/'))
    .pipe(browserSync.stream());
}

function runPublicSass() {
  return gulp
    .src('sass/public/*.scss')
    .pipe(sass())
    .pipe(concat('public.css'))
    .pipe(gulp.dest('../public/stylesheets/'))
    .pipe(browserSync.stream());
}

function reload() {
  browserSync.reload();
}

function watchStaff() {
  browserSync.init({
    server: {
      baseDir: './',
    }
  });
  gulp.watch('sass/staff/*.scss', runStaffSass).on('change', browserSync.reload);
}

function watchPublic() {
  browserSync.init({
    server: {
      baseDir: './',
    }
  });
  gulp.watch('sass/public/*.scss', runPublicSass).on('change', browserSync.reload);
}

// function watch() {
//   browserSync.init({
//     server: {
//       baseDir: './'
//     }
//   });
//   gulp.watch('sass/*.scss', runSass);
//   gulp.watch('*.html', reload);
//   gulp.watch('*.js', reload);
// }

exports.runStaffSass = runStaffSass;
exports.runPublicSass = runPublicSass;
// exports.watch = watch;
exports.watchStaff = watchStaff;
exports.watchPublic = watchPublic;