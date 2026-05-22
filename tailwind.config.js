import defaultTheme from 'tailwindcss/defaultTheme'

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#765630',
                background: '#F6F4F1',
                border: '#D8CEC2',
                gold: '#D9B56D',
                secondary: '#745942',
                'text-primary': '#111111',
                'text-secondary': '#5E5A56',
            },

            fontFamily: {
                serif: ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
}