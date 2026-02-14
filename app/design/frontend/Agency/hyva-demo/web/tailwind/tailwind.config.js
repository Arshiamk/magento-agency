const { spacing } = require("tailwindcss/defaultTheme");

module.exports = {
  mode: "jit",
  purge: {
    content: ["../**/*.phtml", "../../../code/Agency/**/*.phtml"],
  },
  theme: {
    extend: {
      colors: {
        primary: {
          light: "#4da6ff",
          DEFAULT: "#0066cc",
          dark: "#004c99",
        },
      },
    },
  },
  plugins: [require("@tailwindcss/typography"), require("@tailwindcss/forms")],
};
