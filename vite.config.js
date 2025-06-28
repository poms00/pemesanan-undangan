import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    css: {
        devSourcemap: true,
    },
    build: {
        sourcemap: true,
    },
    base: "/build/", // 🛠️ pastikan path asset benar
});
