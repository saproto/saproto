const mix = require('laravel-mix');
const glob = require('glob')
const paths = {
    styles: {
        src: 'resources/assets/sass/',
        components: 'resources/assets/sass/partials/_components.scss'
    },
    scripts: {
        src: 'resources/assets/js/application.js',
    },
    public: 'public/assets/'
}

// Concatenate component SCSS from views folders
mix.before(() => {
    mix.styles('resources/views/**/*.scss', paths.styles.components)
});

//Compile all theme SCSS to public folder
glob.sync('*.scss', {cwd: paths.styles.src}).forEach((fileName,) => {
    let src = paths.styles.src+fileName
    let dest = paths.public+fileName.replace('scss', 'css')
    mix.sass(src, dest);
})

// Compile all javascript
mix
    .js(paths.scripts.src, paths.public)
    .extract()
