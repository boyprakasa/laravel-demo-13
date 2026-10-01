import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { compression } from "vite-plugin-compression2";
import { visualizer } from "rollup-plugin-visualizer";

const analyze = process.env.ANALYZE === "true";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        compression({ algorithm: "brotliCompress" }),
        compression({ algorithm: "gzip" }),
        analyze &&
            visualizer({
                filename: "stats.html",
                gzipSize: true,
                brotliSize: true,
            }),
    ],
    build: {
        target: "es2020",
        sourcemap: false,
        cssCodeSplit: true,
        chunkSizeWarningLimit: 500,
    },
    esbuild: {
        pure: ["console.log", "console.debug"],
        drop: ["debugger"],
        legalComments: "none",
    },
});
