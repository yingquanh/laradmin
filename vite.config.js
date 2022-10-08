import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vitePluginImp from 'vite-plugin-imp'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({

        }),
        vitePluginImp({
            libList: [
                /* {
                    libName: "antd",
                    style: (name) => `antd/lib/${name}/style/index.less`,
                }, */
            ],
        }),
    ],
    css: {
        preprocessorOptions: {
            less: {
                javascriptEnabled: true,
                additionalData: '@root-entry-name: default;',
            },
        },
    },
});
