var gulp = require('gulp');
var elixir = require('laravel-elixir');
var rename = require('gulp-rename');
 
// 拷贝任何需要的文件
gulp.task("copyfiles", function() {
    gulp.src("vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css")
        .pipe(gulp.dest("public/assets/css"));
    gulp.src("vendor/almasaeed2010/adminlte/dist/css/skins/skin-blue.min.css")
        .pipe(gulp.dest("public/assets/css"));
    gulp.src("vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css")
        .pipe(gulp.dest("public/assets/css"));
    gulp.src("vendor/almasaeed2010/adminlte/plugins/jQuery/jquery-2.2.3.min.js")
        .pipe(gulp.dest("public/assets/js"));
    gulp.src("vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js")
        .pipe(gulp.dest("public/assets/js"));
    gulp.src("vendor/almasaeed2010/adminlte/dist/js/app.min.js")
        .pipe(gulp.dest("public/assets/js"));
    gulp.src("vendor/almasaeed2010/adminlte/bootstrap/fonts/**")
        .pipe(gulp.dest("public/assets/fonts"));
    gulp.src("vendor/almasaeed2010/adminlte/dist/img/**")
        .pipe(gulp.dest("public/assets/img"));

    gulp.src("vendor/bower_dl/jquery/dist/jquery.js")
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("vendor/bower_dl/bootstrap/less/**")
        .pipe(gulp.dest("resources/assets/less/bootstrap"));

    gulp.src("vendor/bower_dl/bootstrap/dist/js/bootstrap.js")
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("vendor/bower_dl/bootstrap/dist/fonts/**")
        .pipe(gulp.dest("public/assets/fonts"));

    gulp.src("vendor/bower_dl/font-awesome/less/**")
        .pipe(gulp.dest("resources/assets/less/fontawesome"));

    gulp.src("vendor/bower_dl/font-awesome/fonts/**")
        .pipe(gulp.dest("public/assets/fonts"));

    //拷贝datatables
    var dtDir = 'vendor/bower_dl/datatables-plugins/integration/';
    gulp.src('vendor/bower_dl/datatables/media/js/jquery.dataTables.js')
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src(dtDir + 'bootstrap/3/dataTables.bootstrap.css')
        .pipe(rename('dataTables.bootstrap.less'))
        .pipe(gulp.dest('resources/assets/less/others/'));

    gulp.src(dtDir + 'bootstrap/3/dataTables.bootstrap.js')
        .pipe(gulp.dest('resources/assets/js/'));

    // Copy selectize
    gulp.src("vendor/bower_dl/selectize/dist/css/**")
        .pipe(gulp.dest("public/assets/selectize/css"));

    gulp.src("vendor/bower_dl/selectize/dist/js/standalone/selectize.min.js")
        .pipe(gulp.dest("public/assets/selectize/"));

    // Copy pickadate
    gulp.src("vendor/bower_dl/pickadate/lib/compressed/themes/**")
        .pipe(gulp.dest("public/assets/pickadate/themes/"));

    gulp.src("vendor/bower_dl/pickadate/lib/compressed/picker.js")
        .pipe(gulp.dest("public/assets/pickadate/"));

    gulp.src("vendor/bower_dl/pickadate/lib/compressed/picker.date.js")
        .pipe(gulp.dest("public/assets/pickadate/"));

    gulp.src("vendor/bower_dl/pickadate/lib/compressed/picker.time.js")
        .pipe(gulp.dest("public/assets/pickadate/"));
});
 
 
elixir(function(mix) {

    // 合并 scripts
    mix.scripts(['js/jquery.js','js/bootstrap.js','js/jquery.dataTables.js',
            'js/dataTables.bootstrap.js'],
        'public/assets/js/admin.js',
        'resources/assets'
    );

    // 编译 Less
    mix.less('admin.less', 'public/assets/css/admin.css');
});