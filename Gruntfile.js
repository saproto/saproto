module.exports = function (grunt) {
	/*	Configuration	*/
	var json = {
		pkg: grunt.file.readJSON('package.json'),

		// Grunt banner
		usebanner: {
			dist: {
				options: {
					position: 'top',
					banner:
						'/*! This code was created for S.A. Proto */\n\n' +
						'/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
						'<%= grunt.template.today("yyyy-mm-dd") %> */\n\n\n\n',
					linebreak: true
				},
				files: {
					src: ['<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.destmin %>', '<%= pkg.paths.assets %>/<%= pkg.paths.javascripts.destmin %>']
				}
			}
		},

		// Concatenate JavaScript and SCSS files
		concat: {
			// Concatenate application.js
			js: {
				options: {
					stripBanners: true,
					separator: ';\n',
					process: function (src, filepath) {
						return '// Source: ' + filepath + '\n' +
							src.replace(/(^|\n)[ \t]*('use strict'|"use strict");?\s*/g, '$1');
					},
				},
				src: '<%= pkg.paths.javascripts.src %>',
				dest: '<%= pkg.paths.assets %>/<%= pkg.paths.javascripts.dest %>'
			},
			// Concatenate components.scss
			sass: {
				options: {
					separator: '\n'
				},
				src: '<%= pkg.paths.sass.src %>',
				dest: '<%= pkg.paths.sass.dest %>'
			}
		},

		// Initialise JavaScript
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

		// Compile application-light.scss to application.css
		sass: {
			build: {
				files: [{
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.light.dest %>': '<%= pkg.paths.stylesheets.light.src %>',
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dark.dest %>': '<%= pkg.paths.stylesheets.dark.src %>',
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.rainbowbarf.dest %>': '<%= pkg.paths.stylesheets.rainbowbarf.src %>'
				}]
			}
		},

		cssmin: {
			options: {
				sourceMap: true,
				keepSpecialComments: 0,
				roundingPrecision: -1
			},
			target: {
				files: {
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.light.destmin %>': '<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.light.dest %>',
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dark.destmin %>': '<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.dark.dest %>',
					'<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.rainbowbarf.destmin %>': '<%= pkg.paths.assets %>/<%= pkg.paths.stylesheets.rainbowbarf.dest %>'
				}
			}
		},

		// Adds vendor-prefixed CSS properties
		autoprefixer: {
			files: {
				options: {
					browsers: ['last 2 versions'],
					map: {
						inline: false
					}
				},
				src: '<%= pkg.paths.assets %>/application-*.css' // globbing is also possible here
			}
		},

		// Watch for changes in directories
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
	};

	grunt.initConfig();
	grunt.config.merge(json);

	/*	Load plugins	*/
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-bump');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-banner');
	grunt.loadNpmTasks('grunt-contrib-watch');

	/*	Register tasks	*/
	grunt.registerTask('build:js', ['concat:js', 'uglify']);
	grunt.registerTask('build:sass', ['concat:sass', 'sass', 'autoprefixer', 'cssmin']);

	grunt.registerTask('default', [ 'build:js', 'build:sass', 'usebanner:dist']);

};
