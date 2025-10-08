/**
 * Tailwind CSS Configuration
 * Ajusta as fontes e define os caminhos de conteúdo para purga/scan.
 * Caso queira reativar classes utilitárias customizadas com @apply, basta adicioná-las em app.css
 * dentro de camadas (@layer components/utilities) conforme necessário.
 */

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './storage/framework/views/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    'node_modules/daisyui/**/*.js'
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: [
          'Instrument Sans',
          'ui-sans-serif',
          'system-ui',
          'sans-serif',
          'Apple Color Emoji',
          'Segoe UI Emoji',
          'Segoe UI Symbol',
          'Noto Color Emoji'
        ]
      }
    }
  },
  plugins: []
};
