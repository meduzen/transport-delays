import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import TurboConsole from 'unplugin-turbo-console/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/css/app.css',
              'resources/css/base.css',
              'resources/js/app.js'
            ],
            refresh: [
              'app/**',
              'config/**',
              'lang/**',
              'resources/views/**',
              'routes/**',
            ],
        }),
        TurboConsole(),
    ],
});
