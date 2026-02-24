const { defineConfig, globalIgnores } = require("eslint/config");

const globals = require("globals");
const parser = require("vue-eslint-parser");
const vue = require("eslint-plugin-vue");
const tsPlugin = require("@typescript-eslint/eslint-plugin");
const tsParser = require("@typescript-eslint/parser");
const js = require("@eslint/js");
const prettier = require("eslint-config-prettier");

module.exports = defineConfig([
    js.configs.recommended,
    {
        plugins: {
            "@typescript-eslint": tsPlugin,
        },
        rules: tsPlugin.configs.recommended.rules,
    },
    prettier,
    ...vue.configs["flat/recommended"],
    {
        languageOptions: {
            globals: {
                ...globals.browser,
            },
            parser,
            ecmaVersion: "latest",
            parserOptions: {
                parser: tsParser,
            },
        },

        plugins: {
            vue,
            "@typescript-eslint": tsPlugin,
        },

        rules: {
            "no-undef": "off",
            "vue/multi-word-component-names": "off",
            "@typescript-eslint/no-explicit-any": "off",
        },
    },

    {
        files: ["resources/js/components/ui/**/*.vue"],
        rules: {
            "vue/require-default-prop": "off",
            "@typescript-eslint/no-unused-vars": "off",
        },
    },

    globalIgnores([
        "**/node_modules/",
        "**/dist/",
        "**/js/actions/",
        "**/js/routes/",
        "**/js/wayfinder/",
    ]),
]);
