var gulp       = require('gulp'),
    args       = require('yargs').argv,
    rename     = require('gulp-rename'),
    zip        = require('gulp-zip'),
    sass       = require('gulp-sass'),
    autoprefix = require('gulp-autoprefixer'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify');


var releasePaths = [
    '**/*',
    '!{_releases,_releases/**}',
    '!{node_modules,node_modules/**}',
    '!assets/{scss,scss/**}',
    '!assets/{_js,_js/**}',
    '!.DS_Store',
    '!.gitignore',
    '!composer.json',
    '!composer.lock',
    '!DESCRIPTION',
    '!gulpfile.js',
    '!npm-debug.log',
    '!package.json'
];

var releaseExtrasPaths = [
    'license.txt',
    'installation.txt'
];


/*
    Compile and minify SCSS
 */
gulp.task('css', function() {
    return gulp.src('assets/scss/*.scss')
        .pipe(sass({errLogToConsole: true}))
        .pipe(autoprefix('last 2 versions', '> 1%', 'ie 8', 'ie 9'))
        .pipe(minifyCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('assets/css'));
});


/*
    Minify JS
 */
gulp.task('js', function() {
    return gulp.src('assets/_js/*.js')
        .pipe(uglify({
            'preserveComments': 'some'
        }))
        .pipe(gulp.dest('assets/js'));
});



/*
    Release a package
 */
gulp.task('release', ['css', 'js'], function() {

    /* Create package zip file */
    gulp.src(releasePaths)
        .pipe(rename(function(path) {
            path.dirname = 'hipsterlogin/' + path.dirname;
        }))
        .pipe(zip('hipsterlogin.zip'))
        .pipe(gulp.dest('_releases/' + args.tag));

    /* Copy license and installation instructions */
    gulp.src(releaseExtrasPaths)
        .pipe(gulp.dest('_releases/' + args.tag));

    /* Create main download file */
    // gulp.src('_releases/' + args.tag + '/**')
    //     .pipe(zip('hipsterlogin-codecanyon.zip'))
    //     .pipe(gulp.dest('_releases/' + args.tag));
});

/*
    Watch tasks
 */
gulp.task('watch', function() {
    gulp.watch('assets/scss/**/*.scss', ['css']);
    gulp.watch('assets/_js/*.js', ['js']);
});
