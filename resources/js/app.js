import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import InertiaTitle from "inertia-title/vue3";
import VueLazyLoad from "vue3-lazyload";
import Toast from "vue-toastification";
import VueCountdown from "@chenfengyuan/vue-countdown";
import "../css/tailwind.css";
import "../css/rtl.css";
import "../scss/bootstrap.scss";
import "../scss/common.scss";
import "../scss/index.scss";
import "../scss/responsive.scss";
import * as bootstrap from "bootstrap";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

window.bootstrap = bootstrap;

createInertiaApp({
    id: "app",
    // resolve: name => resolvePageComponent(`./Pages/${name}.vue`),
    resolve: async (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({
        el,
        App,
        props,
        plugin
    }) {
        createApp({
            render: () => h(App, props),
        })
            .component("inertia-link", Link)
            .use(plugin)
            .use(InertiaTitle)
            .use(VueLazyLoad)
            .use(VueSweetalert2)
            .use(Toast, {
                transition: "Vue-Toastification__bounce",
                maxToasts: 20,
                newestOnTop: true,
            })
            .component(VueCountdown.name, VueCountdown)
            .mixin({
                data() {
                    return {
                        // user: props.initialPage.props.user,
                        flash: props.initialPage.props.flash,
                        config: props.initialPage.props.config,
                    };
                },
                computed: {
                    isSubscribed() {
                        // check page is index if index excu code or note
                        if (!this.route().current('index')) {
                            return true;
                        }

                        let user = this.$page?.props?.user;
                        if (user && user.plan_status !== "Not Subscribed") {
                            return true;
                        }
                        return false;
                    }
                },
                methods: {
                    route: window.route,
                    asset: (path) => {
                    },
                    // for multiple language
                    __(key, replace = {}) {
                        var translation = this.$page.props.translations[key] ? this.$page.props.translations[key] : key

                        Object.keys(replace).forEach(function (key) {
                            translation = translation.replace(':' + key, replace[key])
                        });

                        return translation
                    },
                    numberFormat(price, fixed = 2) {
                        const numericValue = parseFloat(price);
                        return numericValue.toFixed(fixed);
                    },
                    currencyConvert(price = 0) {
                        return this.setCurrencySymbol(this.numberFormat(price));
                        if (this.$page?.props?.config?.misc?.currency_code == 'AZN') {
                            const azn_rate = this.$page?.props?.config?.app?.azn_rate;
                            const converted_rate = parseFloat(price) * parseFloat(azn_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'SAR') {
                            const sar_rate = this.$page?.props?.config?.app?.sar_rate;
                            const converted_rate = parseFloat(price) * parseFloat(sar_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'KWD') {
                            const kwd_rate = this.$page?.props?.config?.app?.kwd_rate;
                            const converted_rate = parseFloat(price) * parseFloat(kwd_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'AED') {
                            const aed_rate = this.$page?.props?.config?.app?.aed_rate;
                            const converted_rate = parseFloat(price) * parseFloat(aed_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'BHD') {
                            const bhd_rate = this.$page?.props?.config?.app?.bhd_rate;
                            const converted_rate = parseFloat(price) * parseFloat(bhd_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'QAR') {
                            const qar_rate = this.$page?.props?.config?.app?.qar_rate;
                            const converted_rate = parseFloat(price) * parseFloat(qar_rate);

                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else if (this.$page?.props?.config?.misc?.currency_code == 'GBP') {
                            const pound_rate = this.$page?.props?.config?.app?.pound_rate;
                            const converted_rate = parseFloat(price) * parseFloat(pound_rate);
                            return this.setCurrencySymbol(this.numberFormat(converted_rate));
                        } else {
                            return this.setCurrencySymbol(this.numberFormat(price));
                        }
                    },
                    setCurrencySymbol(amount) {
                        const symbol = this.$page?.props?.config?.misc?.currency_symbol;
                        const position = this.$page?.props?.config?.misc?.currency_position;

                        if (position == 'right') {
                            return amount + ' ' + symbol;
                        } else {
                            return symbol + amount;
                        }
                    }
                },
            })
            .mount(el);

        function isIPhone() {
            const ua = navigator.userAgent;
            return /iPhone|iPad|iPod/.test(ua);
        }

        window.addEventListener('popstate', function (event) {
            if (isIPhone() && window.history.state === null) {
                event.preventDefault();
                Inertia.visit(route('index'));
            }
        });
    },
});
