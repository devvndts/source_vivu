module.exports = function(grunt) {
    const sass = require('node-sass');
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Define Path
        dirs: {
            inputTemplate       : 'resources/views/desktop',
            inputTemplateComponents       : 'resources/views/components',
            input               : 'development',
            inputSCSS           : 'development/sass',
            inputJS             : 'js',
            inputDevJS          : 'development/js',
            inputHTMLELements   : 'development/html-elements',
            output              : 'production',
            assetsJs            : './js/',
            publicCss            : './public/css/',
            outputCSS           : './css/',
            outputJS            : 'js',
        },
        // Plugin 01: CSSmin
        cssmin: {
            options: {
            },
            target: {
                files: {
                    '<%= dirs.outputCSS %>/main.css' : '<%= dirs.outputCSS %>/main.css'
                }
            }
        },
        // Plugin 02: Uglify
        uglify: {
            options: {
                beautify: false,
                compress: {
                    drop_console: true
                }
            },
            my_target: {
                files: {
                    '<%= dirs.outputJS %>/main.js': ['<%= dirs.inputJS %>/main.js']
                }
            },
            // my_advanced_target: {
            //     files: {
            //         '<%= dirs.outputJS %>/plugins.min.js': ['<%= dirs.inputJS %>/plugins.js']
            //     }
            // }
        },

        concat: {
            basic: {
                src: [
                    '<%= dirs.inputJS %>/jquery-migrate-3.1.0.min.js',
                    '<%= dirs.inputJS %>/lazyload.min.js',
                    // '<%= dirs.inputJS %>/bootstrap.min.js',
                    '<%= dirs.inputJS %>/jquery.fancybox.min.js',
                    '<%= dirs.inputJS %>/slick.min.js',
                    // '<%= dirs.inputJS %>/list.min.js',
                    '<%= dirs.inputJS %>/wow.min.js',
                    // '<%= dirs.inputJS %>/magiczoomplus.js',

                    '<%= dirs.inputDevJS %>/my_script.js',
                    '<%= dirs.inputDevJS %>/common.js',
                    '<%= dirs.inputDevJS %>/home.js',
                    '<%= dirs.inputDevJS %>/valak_menu.js',
                    '<%= dirs.inputDevJS %>/timkiem.js',
                    '<%= dirs.inputDevJS %>/newsletter.js',
                    '<%= dirs.inputDevJS %>/totop.js',
                    // '<%= dirs.inputDevJS %>/product.js',
                    '<%= dirs.inputDevJS %>/cart.js',
                ],
                dest: '<%= dirs.inputJS %>/main.js',
            },
            // extras: {
            //     src: [
            //         '<%= dirs.inputJS %>/jquery-migrate-3.1.0.min.js',
            //         '<%= dirs.inputJS %>/lazyload.min.js',
            //         // '<%= dirs.inputJS %>/bootstrap.bundle.min.js',
            //         '<%= dirs.inputJS %>/jquery.fancybox.min.js',
            //         '<%= dirs.inputJS %>/slick.min.js',
            //         '<%= dirs.inputJS %>/list.min.js',
            //         '<%= dirs.inputJS %>/wow.min.js',
            //         '<%= dirs.inputJS %>/magiczoomplus.js',
            //     ],
            //     dest: '<%= dirs.inputJS %>/plugins.js',
            // },
        },
        
        // Plugin 04: Sass
        sass: {
            options: {
                implementation: sass,
                style: 'expanded',
                sourceMap: false
            },
            dist: {
                files: {
                    '<%= dirs.outputCSS %>/main.css': '<%= dirs.inputSCSS %>/main.scss'
                }
            }
        },

        // Plugin 05: watch
        watch: {
            scripts: {
                files: [
                    '<%= dirs.inputSCSS %>/*.scss',             // development/sass/*.scss
                    '<%= dirs.inputSCSS %>/*/*.scss',           // development/sass/*/*.scss
                    '<%= dirs.publicCss %>/*.css',   //'<%= dirs.inputDevJS %>/*.js', 
                    '<%= dirs.assetsJs %>/*.js',   //'<%= dirs.inputDevJS %>/*.js', 
                    'index.html',
                    '<%= dirs.input %>/index.html',
                    '<%= dirs.inputHTMLELements %>/*.html',     // development/html-elements/*.html
                    '<%= dirs.inputTemplateComponents %>/*.php',     // resources/views/components/*.php
                    '<%= dirs.inputTemplateComponents %>/**/*.php',     // resources/views/components/*.php
                    '<%= dirs.inputTemplateComponents %>/**/**/*.php',     // resources/views/components/*.php
                    '<%= dirs.inputTemplate %>/*.php',     // resources/views/desktop/*.php
                    '<%= dirs.inputTemplate %>/**/*.php',     // resources/views/desktop/*/*.php
                    // '<%= dirs.inputTemplate %>/*/*/*.php',     // resources/views/desktop/*/*/*.php
                    //'<%= dirs.inputHTMLELements %>/*/*.html', // development/html-elements/*/*.html
                ],
                // tasks: ['sass'],
                options: {
                    spawn: false,
                    livereload: true
                },
            },
        },
        // Plugin 06: connect
        // connect: {
        //     server: {
        //         options: {
        //             hostname: 'localhost',
        //             port: 3069,
        //             base: '<%= dirs.output %>/',
        //             livereload: true
        //         }
        //     }
        // },
    });
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.registerTask('default', 'Log some stuff.', function() {
    grunt.log.write('Logging some stuff...').ok();
});

    grunt.registerTask('dev', [
    //   'sass',
        // 'connect',
        'watch'
    ]);
    // Task Publish Project
    grunt.registerTask('publish', [
        'cssmin',
        'concat',
        'uglify'
    ]);
    grunt.registerTask('devjs', [
        'concat:basic'
    ]);
}