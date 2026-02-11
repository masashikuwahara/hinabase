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
                sans: ['Noto Sans JP', 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'sans-serif'],
                mont: ['Montserrat', 'Noto Sans JP', 'sans-serif'],
            },
            screens: {
                xs: '450px', // 430px以下で適用
              },
        },
    },
    plugins: [],
};