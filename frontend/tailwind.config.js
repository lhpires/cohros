/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  darkMode: "class", // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'cohrosPrimary': '#10C2A0'
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}