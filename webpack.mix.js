const mix = require("laravel-mix");

/*
 |---------------------------------------------------------------------------
 | Mix Asset Management
 |---------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Enable Vue support and specify the paths for your JavaScript and Sass files
mix.js("resources/js/app.js", "public/assets/js/soft-ui-dashboard.js")
   .vue() // Ensure Vue files are processed correctly
   .sass("resources/scss/soft-ui-dashboard.scss", "public/assets/css/soft-ui-dashboard.css");

// Optional: Enable source maps for easier debugging (remove in production)
if (mix.inProduction()) {
    mix.version(); // Enables cache-busting in production
} else {
    mix.sourceMaps(); // Enables source maps for development
}

// Optional: Add custom Webpack configurations if needed
mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'], // Ensure .vue files are resolved
    },
});
