import {glob} from 'glob';
import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import eslintPlugin from '@nabla/vite-plugin-eslint';
import path from 'path';
import { wayfinder } from "@laravel/vite-plugin-wayfinder";


/**
 * https://vitejs.dev/config/
 * @type {import('vite').UserConfig}
 */
export default defineConfig({
    resolve: {
        alias:
            {
                '@': path.resolve('./resources/js'),
            }
    },
    plugins: [
        laravel({
            input: [
                //The sass files for our themes
                '/resources/js/app.ts',
                '/resources/css/app.css',

                //The sass files for our themes
                '/resources/assets/sass/light.scss',
                ...glob.sync('resources/assets/sass/!(*.example).scss'),

                //js files that get included individually
                '/resources/assets/js/application.js',
                '/resources/assets/js/echo.js',

                //resources for the sticker functionality
                '/resources/assets/js/leaflet.js',
                '/node_modules/leaflet-geosearch/dist/geosearch.css',
                '/node_modules/leaflet.markercluster/dist/MarkerCluster.css',
                '/node_modules/leaflet/dist/leaflet.css',
                //exif-reader for getting the date_taken from photos
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        eslintPlugin({
            fix: true,
            ignores: ['vendor/**/*.js', '/virtual:/**', 'node_modules/**', 'resources/assets/js/**'],
        }),
        wayfinder({
            formVariants: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    bootstrap: ['bootstrap', '@popperjs/core'],
                    interface: ['easymde', 'swiper', 'signature_pad', 'codethereal-iconpicker'],
                },
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: [
                    'import',
                    'color-functions',
                    'global-builtin',
                    'if-function'
                ],
            },
        },
    },
});
