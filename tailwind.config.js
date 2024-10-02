import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

const { createThemes } = require("tw-colors");
/** @type {import("tailwindcss").Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],
    safelist: [],
    theme: {
        extend: {},
    },

    plugins: [
        createThemes({
            light: {
                primary: "#83b71a",
                secondary: "#6c757d",
                brand: "#83b71a",
                success: "#00aac0",
                info: "#00aac0",
                warning: "#f37e16",
                danger: "#c50005",
                omnomcom: "#26ade4",
                dark: "#303030",
                light: "#f1f1f1",
                background: "#F3F3F3",
            },
            dark: {
                primary: "steelblue",
                secondary: "darkblue",
                brand: "#F3F3F3",
                // ...other colors
            },
            rainbowbarf: {
                primary: "steelblue",
                secondary: "darkblue",
                brand: "#F3F3F3",
                // ...other colors
            },
            broto: {
                primary: "steelblue",
                secondary: "darkblue",
                brand: "#F3F3F3",
            },
            nightMode: {
                primary: "steelblue",
                secondary: "darkblue",
                brand: "#F3F3F3",
            },
        }),
        forms,
        typography,
    ],
};
