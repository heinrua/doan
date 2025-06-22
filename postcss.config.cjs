module.exports = {
    plugins: [
        require("postcss-import"),
        require("@tailwindcss/postcss"),
        require("postcss-advanced-variables"),
        // require("tailwindcss")("./tailwind.config.js"),
        require("autoprefixer"),
    ],
};
