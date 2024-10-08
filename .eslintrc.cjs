module.exports = {
    ignorePatterns: ["node_modules/", "dist/"],
    env: {
        browser: true,
        es2022: true
    },
    parser: "vue-eslint-parser",
    parserOptions: {
        ecmaVersion: 2022,
        parser: "@typescript-eslint/parser"
    },
    extends: [
        "eslint:recommended",
        "plugin:@typescript-eslint/recommended",
        "plugin:vue/vue3-recommended",
        "plugin:prettier/recommended"
    ],
    plugins: ["vue", "@typescript-eslint", "prettier"],
    rules: {
        "no-undef": "off"
    }
};
