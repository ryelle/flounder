module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    meta: {
      banner: '/*! <%= pkg.name %> */\n',
    },
    concat: {
      options: {
        banner: '<%= meta.banner %>'
      },
      dist: {
        files: { 'js/<%= pkg.slug %>.js': 'js/src/**/*.js' }
      }
    },
    uglify: {
      options: {
        banner: '<%= meta.banner %>',
        report: 'min' // Shows how well it compressed in the CLI
      },
      dist: {
        files: { 'js/<%= pkg.slug %>.min.js': 'js/<%= pkg.slug %>.js' }
      }
    },
    less: {
      dist: {
        options: { 
          yuicompress: true 
        },
        files: {
        	'style.css': [ 'less/*.less', '!less/_*.less' ],
        	'css/editor.css': 'less/editor.less'
        }
      }
    },
    watch: {
      javascript: {
        files: ['js/src/**/*.js'],
        tasks: ['concat', 'uglify']
      },
      less: {
        files: ['less/*.less'],
        tasks: ['less']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['concat', 'uglify', 'less']);


};