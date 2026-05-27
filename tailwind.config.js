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
      colors: {
        'brand-orange': {
          300: '#FDBA74', // Suave (Plano esquerdo do logo / Detalhes)
          400: '#FB923C', // Claro (Hover states)
          500: '#F97316', // Principal (Botões primários, Destaques)
          600: '#EA580C'  // Escuro (Textos fortes, Plano direito do logo, CTAs Principais)
        }
      },
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
