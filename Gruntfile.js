/**
 * Wplanding Tasks
 *
 * @since 1.0.0
 */
module.exports = function (grunt) {
    'use strict';

    grunt.initConfig({

        /*
         * Package
         */
        pkg: grunt.file.readJSON('package.json'),

        /*
         * Composer Directory
         */
        _composer_dir: 'vendor/',

        /*
         * Npm Modules
         */
        _path_npm_modules: 'node_modules/',

        /**
         * Exec Shell Commands
         */
        exec: {
            dist_zip: 'cd .. && mkdir -p grunt-plugins && zip -r grunt-plugins/wplanding.zip wplanding -x "*.DS_Store"'
        },

        /*
         * Sass Compiler
         */
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    precision: 2,
                    noCache: true
                },
                files: {
                    'assets/css/atd.min.css': 'assets/scss/atd.scss',
                    'assets/css/wpl.min.css': 'assets/scss/wpl.scss',
                }
            }
        },

        /**
         * Js Uglify
         */
        uglify: {
            options: {
                mangle: false,
                compress: false,
                wrap: false
            },
            dist: {
                files: [
                    {
                        expand: true,
                        src: ['assets/js/**/*.js', '!assets/js/**/*.min.js'],
                        dest: 'assets/js/',
                        rename: function (dst, src) {
                            // add .min suffix.
                            return src.replace(/(.js)$/, '.min.js');
                        }
                    }
                ]
            }
        },

        /*
         * Clean Dist
         *
         * Clean the environment by removing development directories and files
         *
         * @link https://www.npmjs.com/package/grunt-contrib-clean
         */
        clean: {
            dist: {
                src: [
                    '.DS_Store',
                    '.idea',
                    '.gitignore',
                    '.git',
                    '.sass-cache',
                    'composer.json',
                    'package.json',
                    'package-lock.json',
                    'composer.lock',
                    'Gruntfile.js',
                    'node_modules',
                    'assets/scss/.sass-cache',
                ]
            }
        },
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-exec');

    grunt.registerTask('script', ['uglify:dist']);

    grunt.registerTask('dist', [
        'uglify:dist',
        'clean:dist',
        'exec:dist_zip'
    ]);
};
