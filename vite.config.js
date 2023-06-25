import glob from 'glob';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
                '/resources/assets/sass/light.scss',
                '/resources/assets/js/application.js',
                ...glob.sync('resources/assets/sass/!(*.example).scss')
            ]),
    ],
    // build: {
    //     rollupOptions: {
    //         output: {
    //             manualChunks: {
    //                 bootstrap: ['bootstrap', '@popperjs/core'],
    //                 interface: ['easymde', 'swiper', 'signature_pad', 'codethereal-iconpicker']
    //             },
    //         },
    //     },
    // },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});