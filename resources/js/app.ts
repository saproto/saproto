import './bootstrap';
import '../css/app.css';
import 'vue3-toastify/dist/index.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Vue3Toastify, { toast, type ToastContainerOptions } from 'vue3-toastify';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const appEnv = import.meta.env.VITE_APP_ENV || 'production';

import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
    title: (title) => `${appEnv !== 'production' ? '[' + appEnv.toUpperCase() + '] ' : ''}${appName} | ${title}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toastify, {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastContainerOptions)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
