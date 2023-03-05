const gulp = require("gulp");
const shell = require("gulp-shell");
const watch = require("gulp-watch");

gulp.task(
  "compile-sass",
  shell.task("php -r \"require_once 'compomatic.php'; compile_sass();\"")
);

gulp.task("watch", function () {
  watch("./components/*.php", gulp.series("compile-sass"));
});
