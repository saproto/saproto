import './bootstrap'
import '../css/app.css'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

const appName = import.meta.env.VITE_APP_NAME || 'S.A. Proto'
const appEnv = import.meta.env.VITE_APP_ENV || 'production'

import { ZiggyVue } from 'ziggy-js'

createInertiaApp({
    title: (title) =>
        `${appEnv !== 'production' ? '[' + appEnv.toUpperCase() + '] ' : ''}${appName} | ${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
