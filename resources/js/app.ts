import { createInertiaApp, usePage } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h, watch } from 'vue';
import { createI18n } from 'vue-i18n';
import '../css/app.css';
import { initializeTheme } from './composables/useAppearance';

import de from './locales/de.json';
import en from './locales/en.json';
import es from './locales/es.json';
import tr from './locales/tr.json';
import ar from './locales/ar.json';
import fr from './locales/fr.json';
import it from './locales/it.json';
import nl from './locales/nl.json';
import pt from './locales/pt.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const locale = (props.initialPage.props.locale as string) || 'en';
        const i18n = createI18n({
            legacy: false,
            locale,
            fallbackLocale: 'en',
            messages: { en, de, tr, es, ar, fr, it, nl, pt },
        });

        // Watch the Inertia page locale prop reactively from inside the Vue tree
        // so it stays in sync across all soft navigations.
        const root = {
            setup() {
                const page = usePage();
                watch(
                    () => page.props?.locale as string | undefined,
                    (newLocale) => {
                        if (newLocale && i18n.global.locale.value !== newLocale) {
                            i18n.global.locale.value = newLocale;
                        }
                    },
                );
            },
            render: () => h(App, props),
        };

        createApp(root).use(plugin).use(i18n).mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
