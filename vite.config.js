import { glob } from 'glob'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import eslintPlugin from '@nabla/vite-plugin-eslint'
import path from 'path'
import { wayfinder } from '@laravel/vite-plugin-wayfinder'
import { sentryVitePlugin } from '@sentry/vite-plugin'
/**
 * https://vitejs.dev/config/
 * @type {import('vite').UserConfig}
 */
export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve('./resources/js'),
        },
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
                '/resources/assets/js/signature-pad.js',
                '/resources/assets/js/exifreader.js',
                '/resources/assets/js/iconpicker.js',
                '/resources/assets/js/moment.js',

                //resources for the sticker functionality
                '/resources/assets/js/leaflet.js',
                '/node_modules/leaflet-geosearch/dist/geosearch.css',
                '/node_modules/leaflet.markercluster/dist/MarkerCluster.css',
                '/node_modules/leaflet/dist/leaflet.css',
            ],
            refresh: true,
        }),
        wayfinder({
            formVariants: true,
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
            ignores: [
                'vendor/**/*.js',
                '/virtual:/**',
                'node_modules/**',
                'resources/assets/js/**',
            ],
        }),
        process.env.SENTRY_AUTH_TOKEN &&
            sentryVitePlugin({
                org: process.env.SENTRY_ORG,
                project: process.env.SENTRY_PROJECT,
                authToken: process.env.SENTRY_AUTH_TOKEN,
                sourcemaps: {
                    // As you're enabling client source maps, you probably want to delete them after they're uploaded to Sentry.
                    // Set the appropriate glob pattern for your output folder - some glob examples below:
                    filesToDeleteAfterUpload: [
                        './**/*.map',
                        '.*/**/public/**/*.map',
                        './dist/**/client/**/*.map',
                    ],
                },
            }),
    ],
    build: {
        sourcemap: 'hidden',
        rollupOptions: {
            output: {
                manualChunks: {
                    bootstrap: ['bootstrap', '@popperjs/core'],
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
