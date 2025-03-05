import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'public/build',
    },
    server: {
        proxy: {
            '/app': 'http://localhost', // Adjust as per your Laravel setup
        },
    },
});
