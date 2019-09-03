/**
 * Setting entrypath by checking the variable bp_site.
 */
if (window.bp_site) {
  __webpack_public_path__ = window.bp_site['dist'];
}
