/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: ["./views/**/*.{html,js,php}"],
  theme: {
    extend: {
      keyframes: {
        float: {
          "0%, 100%": { transform: "translate(0)" },
          "50%": { transform: "translate(42px, 18px)" },
        },
      },
      animation: {
        floating: "float 2s ease-in-out infinite",
      },
    },
  },
  plugins: [],
};
