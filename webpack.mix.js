const mix = require('laravel-mix')
const glob = require('glob')
require('laravel-mix-purgecss')

const paths = {
    styles: {
        src: 'resources/assets/sass/',
        dst: 'public/css/'
    },
    scripts: {
        src: 'resources/assets/js/',
        dst: 'public/js/',
        chunks: {
            bootstrap: ['bootstrap', 'popper.js'],
            interface: ['easymde', 'swiper', 'signature_pad', 'codethereal-iconpicker']
        }
    },
}

mix .webpackConfig({ devtool: "inline-source-map" })
    .options({
        postCss: [
            require('postcss-discard-comments')({
                removeAll: true
            })
        ],
        uglify: {
            comments: false
        }
    })

//Compile all theme SCSS
glob.sync('!(*.example).scss', {cwd: paths.styles.src}).forEach(fileName => {
    let src = paths.styles.src+fileName
    let dest = paths.styles.dst+'application-'+fileName.replace('scss', 'css')
    mix .sass(src, dest, {
            sassOptions: { quietDeps: true } // Mute deprecation warnings because of Bootstrap 4
        })
        .purgeCss()
})

// Compile all javascript
mix.js(paths.scripts.src+'application.js', paths.scripts.dst)
Object.entries(paths.scripts.chunks).forEach(([name, packages]) => {
    mix.extract(packages, paths.scripts.dst+name+'~vendor.js')
})
mix.extract()

// Enable versioning
mix.version()
