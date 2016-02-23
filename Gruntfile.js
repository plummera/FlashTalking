/*global module:false*/
module.exports = function(grunt) {

// Project configuration.
grunt.initConfig({
  pkg: grunt.file.readJSON('package.json'),

  /**
   * Set project object
   */

  project: {
    name: 'FlashTalker',
    website: 'https://www.github.com/plummera/flashtalking/',
    assets: 'assets',
    author: 'Anthony T. Plummer',
    css: 'style.css',
    scss: '<%= project.assets %>/scss/css/style.scss',
    js: '<%= project.assets %>/js/main.js'
  },

  // Metadata.
  meta: {
    version: '0.1'
  },

  banner: '/*! <%= project.name %> - v<%= meta.version %> - ' +
    '<%= grunt.template.today("yyyy-mm-dd") %>\n ' +
    '* <%= project.website %>/\n' +
    '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
    '<%= project.author %>; Unlicensed for the free! */\n',

  // Task configuration.
  concat: {
    options: {
      banner: '<%= banner %>',
      stripBanners: true,
      seperator: ';'
    },

    sass: {
      src: ['<%= project.assets %>/scss/css/**/*.scss'],
      dest: '<%= project.assets %>/scss/css/style.scss'
    },

    js: {
      src: '<%= project.assets %>/**/*.js',
      dest: '<%= project.js %>'
    }
  },

  uglify: {
    options: {
      banner: '<%= banner %>'
    },
    dist: {
      files: {
        '<%= project.assets %>/js/<%= pkg.name %>.min.js' : ['<%= project.js %>']
      }
    }
  },

  jshint: {
    options: {
      curly: true,
      eqeqeq: true,
      immed: true,
      latedef: true,
      newcap: true,
      noarg: true,
      sub: true,
      undef: true,
      unused: true,
      boss: true,
      eqnull: true,
      browser: true,
      globals: {
        jQuery: true,
        "$": false
      }
    },
    flashTalker: {
      src: ['<%= project.assets %>/js/**/*.js']
    }
  },

  /**
   * Sass
   */
  sass: {
    flashTalker: {
      options: {
        style: 'expanded',
        compass: true
      },

      files: {
        'css/style.css': '<%= project.assets %>/scss/css/style.scss'
      }
    }
  },

  // less: {
  //   // Compile all targeted LESS files individually
  //   components: {
  //     options: {
  //       imports: {
  //         // Use the new "reference" directive, e.g.
  //         // @import (reference) "variables.less";
  //         reference: [
  //           'variables.less',
  //           'mixins.less',
  //           'scaffolding.less',
  //           'forms.less',
  //           'buttons.less',
  //           'utilities.less'
  //         ]
  //       }
  //     },
  //     files: [
  //       {
  //         expand: true,
  //         cwd: '<%= project.assets %>/bootstrap/less',
  //         // Compile each LESS component excluding "bootstrap.less",
  //         // "mixins.less" and "variables.less"
  //         src: ['*.less'],
  //         dest: 'css/',
  //         ext: '.css'
  //       }
  //     ]
  //   }
  // },

  watch: {
    options: {
      livereload: true
    },

    flashTalker: {
      files: ['<%= project.assets %>/js/**/*.js', '<%= project.assets %>/scss/css/**/*.scss'],
      tasks: ['jshint', 'concat:sass', 'sass', 'concat', 'uglify']
    }
  }
});

// These plugins provide necessary tasks.
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-jshint');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-sass');
grunt.loadNpmTasks('grunt-contrib-livereload');
grunt.loadNpmTasks('grunt-contrib-compass');

// Default task.
grunt.registerTask('default', ['jshint', 'concat:sass', 'sass', 'concat', 'uglify']);
}
