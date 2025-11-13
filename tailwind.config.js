import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#42e3d4',
            },
            // Yeh 2 lines add karo
            backgroundImage: {
                'gradient-primary': 'linear-gradient(to right, #42e3d4, #22d3ee)',
            },
            boxShadow: {
                'primary-glow': '0 0 20px rgba(66, 227, 212, 0.4)',
            },
        },
    },
    plugins: [],
};