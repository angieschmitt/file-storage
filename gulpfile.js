/*************
* Requires
**************/
var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');
var notify = require('gulp-notify');
var rename = require('gulp-rename');


/*************
* Default Task
**************/
var defaultBuild = 'prod';


/*************
* Paths
**************/
var sassFiles = {
    src : [ 'assets/scss/*.scss', 'assets/scss/**/*.scss' ],
    dist : 'assets/css/',
    watch : [ 'assets/scss/*.scss', 'assets/scss/**/*.scss' ]
};

/*************
* Functions
**************/
var sassOnError = function( err ) {

    notify.onError({
        title:    "SASS",
        subtitle: "Failure!",
        message:  "Error: <%= error.message %>",
       // sound:    "Beep"
    })( err );

    this.emit( 'end' );
};

var sassTask = function( compression ) {

    return gulp.src( sassFiles.src )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            errLogToConsole: true,
            outputStyle: compression
        }).on( 'error', sassOnError ) )
        .pipe(cleanCSS({
            compatibility: "ie11"
        }))
        .pipe( sourcemaps.write( '.' ) )
        .pipe( gulp.dest( sassFiles.dist ) );
}

/*************
* SASS Tasks
**************/
gulp.task( 'sass:prod', function(done) {

    var sassCompression = 'compressed';

    sassTask( sassCompression );
    done();
}); // gulp sass:prod

/*************
* Watch Tasks
**************/
gulp.task( 'default', function(done) {

    gulp.watch( sassFiles.watch, gulp.series('sass:' + defaultBuild)); // sass
    done();
}); // gulp

gulp.task( 'prod', gulp.series('sass:prod')); // gulp prod
