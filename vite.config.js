import { glob } from 'glob';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import eslintPlugin from '@nabla/vite-plugin-eslint';
import path from 'path';

export default defineConfig({
  resolve: {
    alias: {
      'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
    },
  },
  plugins: [
    laravel({
      input: [
        'resources/js/app.ts',
        '/resources/assets/js/application.js',
        ...glob.sync('resources/assets/sass/!(*.example).scss'),
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
      ignores: ['resources/js/*.js', 'vendor/**/*.js', '/virtual:/**', 'node_modules/**', 'resources/assets/js/**'],
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
});
