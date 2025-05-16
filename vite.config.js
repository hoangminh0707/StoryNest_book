import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/client.css',
                'resources/js/client.js',

                'resources/js/client/vendor/modernizr-3.6.0.min.js',
                'resources/js/client/plugins/jqueryui.min.js',
                'resources/js/client/plugins/nice-select.min.js',
                'resources/js/client/plugins/slick.min.js',
                'resources/js/client/plugins/ajax-mail.js',
                'resources/js/client/plugins/ajaxchimp.js',
                'resources/js/client/plugins/countdown.min.js',
                'resources/js/client/plugins/image-zoom.min.js',
                'resources/js/client/plugins/imagesloaded.pkgd.min.js',

                'resources/js/client/main.js',

            ],
            refresh: true,
        }),
    ],
});