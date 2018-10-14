module.exports = function (grunt) {
	window = {};

	var json = {
		pkg: grunt.file.readJSON('package.json'),

		copy: {
			fontawesome: {
				expand: true,
				cwd: './node_modules/@fortawesome/fontawesome-free/webfonts',
				src: '**',
				dest: '<%= pkg.paths.assets %>/fonts/'
			}
		},

		/*
		 * Concatenate Javascript files
		 */
		concat: {
			js: {
				options: {
					separator: ';\n',
					stripBanners: true,
					banner: '/*! This code was created for S.A. Proto */\n\n' +
						'/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
						'<%= grunt.template.today("yyyy-mm-dd") %> */\n\n\n\n',
					process: function (src, filepath) {
						return '// Source: ' + filepath + '\n' +
							src.replace(/(^|\n)[ \t]*('use strict'|"use strict");?\s*/g, '$1');
					},
				},
				src: '<%= pkg.paths.javascripts.src %>',
				dest: '<%= pkg.paths.assets %>/<%= pkg.paths.javascripts.dest %>'
			},
			sass: {
				options: {
					separator: '\n'
				},
				src: '<%= pkg.paths.sass.src %>',
				dest: './<%= pkg.paths.sass.dest %>'
			}
		},

		uglify: {
			my_target: {
		      options: {
		        sourceMap: true
		      },
		      files: {
		        '<%= pkg.paths.assets %>/<%= pkg.paths.javascripts.destmin %>': ['<%= pkg.paths.assets %>/<%= pkg.paths.javascripts.dest %>']
		      }
		    }
		},

		bump: {
			options: {
				files: ['package.json'],
				updateConfigs: [],
				commit: true,
				commitMessage: 'Release %VERSION%',
				commitFiles: ['package.json'],
				createTag: true,
				tagName: '%VERSION%',
				tagMessage: 'Version %VERSION%',
				push: true,
				pushTo: 'origin',
				gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d',
				globalReplace: false,
				prereleaseName: false,
				regExp: false
			}
		},

		/*
		 * Initialise SASS
		 */
		sass: {
			importer: importOnce,
			importOnce: {
				index: false,
				css: true
			},
			options: {
				outputStyle: 'expanded',
				sourceComments: true,
				includePaths: [],
			},
			dist: {
				files: {
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dest %>': '<%= pkg.paths.stylesheets.src %>'
				}
			}
		},

		cssmin: {
			options: {
				sourceMap: true,
				keepSpecialComments: 1,
				roundingPrecision: -1
			},
			target: {
				files: {
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.destmin %>': [
						'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dest %>']
				}
			}
		},

		autoprefixer: {
			files: {
				options: {
					browsers: ['last 2 versions'],
					map: {
						inline: false
					}
				},
				src: '<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dest %>' // globbing is also possible here
			}
		},

		/*
		 * Watch for changes in directories
		 */
		watch: {
			javascripts: {
				files: '<%= pkg.paths.javascripts.watch %>',
				tasks: ['build:js']
			},
			html: {
				files: './app/**/*.html',
				tasks: ['build:html']
			},
			sass: {
				files: '<%= pkg.paths.sass.watch %>',
				tasks: ['build:sass']
			}
		}
	}

	require('load-grunt-tasks')(grunt); // npm install --save-dev load-grunt-tasks
	var importOnce = require('node-sass-import-once');

	grunt.initConfig();
	grunt.config.merge(json);

	/*
	 * Load NPM Plugins
	 */
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-bump');
	grunt.loadNpmTasks('grunt-autoprefixer');

	/*
	 * Register Tasks
	 */
	grunt.registerTask('build:js', ['concat:js', 'uglify']);
	grunt.registerTask('build:sass', ['concat:sass', 'sass', 'cssmin', 'autoprefixer']);

	grunt.registerTask('default', ['build:js', 'build:sass', 'copy:fontawesome']);

};
