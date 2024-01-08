import { ACCESS_TOKEN_MAX_AGE } from './plugins/relipa/config'

module.exports = {
  ssr: true,
  env: {
    baseUrl: process.env.BASE_URL || 'http://localhost:8000'
  },
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'Gachapo',
    htmlAttrs: {
      lang: 'ja'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '@/assets/scss/common.scss',
    '@/assets/scss/main.scss'
  ],

  pwa: {
    manifest: {
      lang: 'ja'
    }
  },

  // Auth module configuration: https://auth.nuxtjs.org
  auth: {
    localStorage: false,
    redirect: {
      login: '/login',
      logout: '/login',
      home: false,
      user: '/profile'
    },
    strategies: {
      local: {
        endpoints: {
          login: { url: '/login', method: 'post', propertyName: 'data.access_token' },
          user: { url: '/auth/me', method: 'get', propertyName: 'data' },
          logout: { url: '/logout', method: 'post' }
        }
      }
    },
    cookie: {
      options: {
        maxAge: ACCESS_TOKEN_MAX_AGE
      }
    },
    plugins: [
      '~/plugins/relipa/index.js'
    ]
  },

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@/plugins/relipa',
    '@/plugins/vee-validate',
    '@/plugins/filters.js',
    '@/plugins/directives'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://github.com/nuxt-community/moment-module
    '@nuxtjs/pwa'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    // https://auth.nuxtjs.org
    '@nuxtjs/auth',
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://i18n.nuxtjs.org/
    '@nuxtjs/i18n',
    // https://github.com/nuxt-community/style-resources-module
    '@nuxtjs/style-resources',
    // https://github.com/microcipcip/cookie-universal/tree/master/packages/cookie-universal-nuxt
    'cookie-universal-nuxt',
    // https://www.npmjs.com/package/@nuxtjs/dayjs
    '@nuxtjs/dayjs'
  ],
  bootstrapVue: {
    icons: true
  },

  // Style resources module configuration: https://github.com/nuxt-community/style-resources-module#readme
  styleResources: {
    scss: [
      '~/assets/scss/variables.scss',
    ]
  },

  // Auth module configuration: https://auth.nuxtjs.org
  auth: {
    localStorage: false,
    redirect: {
      login: '/login',
      logout: '/logout',
      home: false,
      user: '/profile'
    },
    strategies: {
      local: {
        endpoints: {
          login: { url: '/login', method: 'post', propertyName: 'data.access_token' },
          user: { url: '/auth/me', method: 'get', propertyName: 'data' },
          logout: { url: '/logout', method: 'post' }
        }
      }
    },
    cookie: {
      options: {
        maxAge: ACCESS_TOKEN_MAX_AGE
      }
    },
    plugins: [
      '~/plugins/relipa/index.js',
    ]
  },

  rules: {
    'nuxt/no-cjs-in-config': 'off'
  },

  i18n: {
    locales: [
      { code: 'ja', iso: 'ja-JP' },
      { code: 'en', iso: 'en-US' }
    ],
    strategy: 'no_prefix',
    // Detect locale of browser.
    detectBrowserLanguage: false,
    defaultLocale: 'ja',
    locale: 'ja',
    vueI18n: {
      fallbackLocale: 'ja',
      messages: {
        ja: require('./configs/locales/ja-JP.json'),
        en: require('./configs/locales/en-US.json'),
      },
      silentTranslationWarn: true
    }
  },

  // Optional
  dayjs: {
    locales: ['en', 'ja'],
    defaultLocale: 'ja',
    defaultTimeZone: 'Asia/Tokyo',
    plugins: [
      'utc', // import 'dayjs/plugin/utc'
      'timezone' // import 'dayjs/plugin/timezone'
    ] // Your Day.js plugin
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL:  process.env.BASE_URL || 'http://localhost:8000'
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    transpile: ['@stylelib', 'vee-validate'],
  }
}
