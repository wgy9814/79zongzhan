//google chrome 需要安装livereload，地址：  https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei
var gulp = require('gulp');
var livereload = require('gulp-livereload'),//网页自动刷新（服务器控制客户端同步刷新）
    webserver = require('gulp-webserver');//本地服务器//注册任务
gulp.task('webserver', function () {
    gulp.src('./Apps/Tpl/')//服务器目录（./代表根目录）
        .pipe(webserver({//运行gulp-webserver
            livereload: true,//启用LiveReload
            open: true//服务器启动时自动打开网页
        }));
});//监听任务
gulp.task('watch', function () {
    gulp.watch(['./Apps/Tpl/**/*.css', './Apps/Tpl/**/*.html'],//, './Apps/** /** /*.js', './Apps/** /** /*.php'],
        function (file) {//该站点根目录
            livereload.changed(file.path);
            console.log(file.path + " is changed.");
        });
});
gulp.task('default', ['webserver', 'watch']);


/*
var gulp = require('gulp');
var connect = require('gulp-connect');  


gulp.task('start', function () {  
    console.log('gulp run.');
});

gulp.task('watch', function () {  
    gulp.watch(['./Apps/Tpl/Home/Default/*.html'], ['reloadhtml']);  
});

gulp.task('connect', function () {
    console.log('server run ok.');
    connect.server({  
        root: './Apps/Tpl/Home/Default',  
        livereload: true  
    });  
});  

gulp.task('reloadhtml', function ($file) {  
    console.log('reload html...');
    //console.log($file);
    
    gulp.src('./Apps/Tpl/Home/Default/*.html')  
        .pipe(connect.reload());  

});


gulp.task('default', ['start', 'connect', 'watch']);
*/