var gulp = require("gulp");

/**
 *  front-end resource
 */
gulp.task('toAssets', function () {
    gulp.src('./node_modules/jquery/dist/*')        .pipe(gulp.dest("public/dist/jquery/"));
    gulp.src('./node_modules/clipboard/dist/*')     .pipe(gulp.dest("public/dist/clipboard/"));
});

// --------------------------------------------------------------------------------

gulp.task('default', function() {
    gulp.run('toAssets');
});
