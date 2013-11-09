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
    less: {
      dist: {
        files: {
        	'style.css': [ 'less/*.less', '!less/editor.less', '!less/_*.less' ],
        	'editor-style.css': 'less/editor.less'
        }
      }
    },
    watch: {
      javascript: {
        files: ['js/src/**/*.js'],
        tasks: ['concat']
      },
      less: {
        files: ['less/*.less'],
        tasks: ['less']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['concat', 'less']);


};