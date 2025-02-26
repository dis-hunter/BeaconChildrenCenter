import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/js/app.js',
                ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
            integrity: true,
        }),
    ],
    resolve: {
        alias: {
            '@' : 'resources/js',
        },
    },
    build: {
        commonjsOptions: {
            include : [/node_modules/],
        },
    },
});
