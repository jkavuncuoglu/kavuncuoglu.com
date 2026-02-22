import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createSSRApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { renderToString } from 'vue/server-renderer';
import de from './locales/de.json';
import en from './locales/en.json';
import es from './locales/es.json';
import tr from './locales/tr.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer(
    (page) =>
        createInertiaApp({
            page,
            render: renderToString,
            title: (title) => (title ? `${title} - ${appName}` : appName),
            resolve: (name) =>
                resolvePageComponent(
                    `./pages/${name}.vue`,
                    import.meta.glob<DefineComponent>('./pages/**/*.vue'),
                ),
            setup: ({ App, props, plugin }) => {
                const locale = (props.initialPage.props.locale as string) || 'en';
                const i18n = createI18n({
                    legacy: false,
                    locale,
                    fallbackLocale: 'en',
                    messages: { en, de, tr, es },
                });
                return createSSRApp({ render: () => h(App, props) }).use(plugin).use(i18n);
                // SSR: locale is fixed per request, no watcher needed
            },
        }),
    { cluster: true },
);
