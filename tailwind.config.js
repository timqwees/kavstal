/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.php',
    './public/components/**/*.php',
    './public/market/katalog/.template/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        'kav-red': '#ef4444',
      },
    },
  },
  plugins: [],
}
