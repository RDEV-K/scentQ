/** @type {import('tailwindcss').Config} */
module.exports = {
    mode: 'jit',
    prefix: 'tw-',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            ringWidth: ['hover', 'active'],
            fontFamily: {
                'TT-Norms': "'TT Norms Pro', sans-serif",
            },
            colors: {
                'primary': "#EEDFD3",
                'secondary': "#F7F0EA",
                'gold': '#c7a17f',
                'gold-50': '#b17742',
                'gold-dark': '#4b1615'
            },
        }
    },
    plugins: [],
}
