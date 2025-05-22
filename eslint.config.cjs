const {
    defineConfig,
    globalIgnores,
} = require("eslint/config");

const globals = require("globals");
const parser = require("vue-eslint-parser");
const vue = require("eslint-plugin-vue");
const typescriptEslint = require("@typescript-eslint/eslint-plugin");
const prettier = require("eslint-plugin-prettier");
const js = require("@eslint/js");

const {
    FlatCompat,
} = require("@eslint/eslintrc");

const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});

module.exports = defineConfig([{
    languageOptions: {
        globals: {
            ...globals.browser,
        },

        parser: parser,
        ecmaVersion: 2022,

        parserOptions: {
            parser: "@typescript-eslint/parser",
        },
    },

    extends: compat.extends(
        "eslint:recommended",
        "plugin:@typescript-eslint/recommended",
        "plugin:vue/vue3-recommended",
        "plugin:prettier/recommended",
    ),

    plugins: {
        vue,
        "@typescript-eslint": typescriptEslint,
        prettier,
    },

    rules: {
        "no-undef": "off",
        "vue/multi-word-component-names": "off",
        "@typescript-eslint/no-explicit-any": "off"
    },
}, globalIgnores(["**/node_modules/", "**/dist/"])]);
