/* ========================================================================
 * Custom import of Bootstrap modules
 * comment/uncomment the things you do/don't need.
 * import then needed Font Awesome functionality
 * ======================================================================== */

import 'bootstrap/js/dist/button';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/offcanvas';
import { domReady } from './components/domReady';
import example from './components/example-import';
/**
 * Run the application when the DOM is ready.
 */
domReady(() => {
    example();
});

/**
 * Accept module updates
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
import.meta.webpackHot?.accept(console.error);