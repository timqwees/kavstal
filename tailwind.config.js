/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './index.php',
        './public/**/*.{php,html,js}',
        './public/market/katalog/.template/**/*.{php,html,js}',
        './app/**/*.{php,html,js}',
        './setting/**/*.{php,html,js}',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
