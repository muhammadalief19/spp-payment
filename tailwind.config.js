/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        "base-100": "#f1f5f9",
        "base-200": "#e2e8f0",
        "base-300": "#cbd5e1",
        primary: "#395B64",
        secondary: "#A5C9CA",
        tertiary: "#2C3333",
        info: "#0ea5e9",
        "info-focus": "#0284c7",
        success: "#22c55e",
        "success-focus": "#16a34a",
        warning: "#facc15",
        "warning-focus": "#eab308",
        error: "#dc2626",
        "error-focus": "#b91c1c",
      },
    },
  },
  plugins: [],
};
