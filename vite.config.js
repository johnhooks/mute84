import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel([
      "resources/css/app.css",
      "resources/js/app.js",
      "resources/js/audio.js",
      "resources/js/player.js",
      "resources/js/sampler.js",
      "resources/js/three.js",
      "resources/js/effect-01.js",
      "resources/js/polyfill.js",
    ]),
  ],
});
