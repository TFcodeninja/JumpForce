import { defineConfig } from "vite";

export default defineConfig({
  server: {
    port: 3000,
    proxy: {
      // Toutes les requêtes commençant par /api seront redirigées
      // vers le back qui écoute sur 127.0.0.1:8000
      "/api": {
        target: "http://127.0.0.1:8000",
        changeOrigin: true,
        secure: false,
      },
    },
  },
});
