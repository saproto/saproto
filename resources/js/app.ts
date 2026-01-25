import '../css/app.css'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import * as Sentry from '@sentry/vue'

const appName = import.meta.env.VITE_APP_NAME || 'S.A. Proto'
const appEnv = import.meta.env.VITE_APP_ENV || 'production'

createInertiaApp({
    title: (title) =>
        `${appEnv !== 'production' ? '[' + appEnv.toUpperCase() + '] ' : ''}${appName} | ${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {

        const sentryDsn = props.initialPage.props.sentry.dsn
        const sentrySampleRate = props.initialPage.props.sentry.sampling_rate

        const app = createApp({ render: () => h(App, props) });

            Sentry.init({
                app,
                dsn: sentryDsn,
                sendDefaultPii: false,
                tracesSampleRate: !sentrySampleRate?undefined:parseFloat(sentrySampleRate),
                tracePropagationTargets: [
                    'localhost',
                    /^https:\/\/proto\.utwente\.nl/,
                ],
            })

            app.use(plugin)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
