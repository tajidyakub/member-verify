var gulp = require("gulp");
var watch = require("gulp-watch");

var source = "./member-verify",
  destination =
    "/Users/tjrocks/Documents/Projects/Tj-Web/tajidyakub/wp-content/plugins/member-verify";

gulp.task("default", ["copy-folder", "watch-folder"]);

gulp.task("copy-folder", function() {
  gulp.src(source + "/**/*", { base: source }).pipe(gulp.dest(destination));
});

gulp.task("watch-folder", function() {
  gulp
    .src(source + "/**/*", { base: source })
    .pipe(watch(source, { base: source }))
    .pipe(gulp.dest(destination));
});
