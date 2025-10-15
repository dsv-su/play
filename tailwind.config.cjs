// tailwind.config.cjs
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.{html,js,jsx,ts,tsx,php,twig,vue}',
        './content/**/*.md',
        './app/**/*.php',
        './vendor/haringsrob/livewire-datepicker/resources/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
        './node_modules/preline/dist/*.js',
        './node_modules/@preline/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto','Nunito','Inter','Helvetica','Arial','sans-serif'],
                serif: ['Merriweather','Georgia','Cambria','Times New Roman','serif'],
                mono: ['Courier New','monospace'],
                sudepartment: ['TheSansB2-Light','Verdana','sans-serif'],
                rock: ['Rock Salt'],
            },
            colors: {
                suprimary: '#002f5f',
                sudepartment: '#33587f',
                susecondary: '#acdee6',
                dsv: '#f2f3fa',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
};
