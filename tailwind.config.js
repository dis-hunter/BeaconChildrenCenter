import { rose, indigo, green, amber } from 'tailwindcss/colors'
import { fontFamily as _fontFamily } from 'tailwindcss/defaultTheme'


export const content = [
    './packages/admin/resources/**/*.blade.php',
    './packages/forms/resources/**/*.blade.php',
    './packages/notifications/resources/**/*.blade.php',
    './packages/support/resources/**/*.blade.php',
    './packages/tables/resources/**/*.blade.php',
    './resources/**/*.blade.php',
    './vendor/filament/**/*.blade.php', 
]
export const darkMode = 'class'
export const theme = {
    extend: {
        colors: {
            danger: rose,
            primary: indigo,
            success: green,
            warning: amber,
        },
        fontFamily: {
            sans: ['DM Sans', ..._fontFamily.sans],
        },
    },
}
export const plugins = [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
]

const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
