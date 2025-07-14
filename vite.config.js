import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';
export default defineConfig({
    build: {
        commonjsOptions: {
            include: ["tailwind.config.js", "node_modules/**"],
        },
    },
    optimizeDeps: {
        include: ["tailwind-config"],
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/js/vendors/modal.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            "tailwind-config": path.resolve(__dirname, "./tailwind.config.js"),
        },
    },
});
