const {
    defineConfig,
    globalIgnores,
} = require("eslint/config");

const globals = require("globals");
const parser = require("vue-eslint-parser");
const vue = require("eslint-plugin-vue");
const typescriptEslint = require("@typescript-eslint/eslint-plugin");
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
        ecmaVersion: "latest",

        parserOptions: {
            parser: "@typescript-eslint/parser",
        },
    },

    extends: [...compat.extends(
        "eslint:recommended",
        "plugin:@typescript-eslint/recommended",
        "prettier",
    ),
        vue.configs["flat/recommended"],

    ],

    plugins: {
        vue,
        "@typescript-eslint": typescriptEslint,
    },

    rules: {
        "no-undef": "off",
        "vue/multi-word-component-names": "off",
        "@typescript-eslint/no-explicit-any": "off"
    },
},
    {
        files: ["resources/js/components/ui/**/*.vue"],
        rules: {
            "vue/require-default-prop": "off",
            "@typescript-eslint/no-unused-vars": "off"
        },
    },globalIgnores(["**/node_modules/", "**/dist/", "**/js/actions/",
        "**/js/routes/",
        "**/js/wayfinder/"])]);
