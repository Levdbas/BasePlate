# BasePlate

BasePlate is a starter theme for WordPress that includes an up-to-date asset manager via WebPack. It comes with a custom WebPack4 build for compiling css, js, importing jQuery, Bootstrap and manages assets such as fonts and images. Last but not least, it utilizes cache busting by randomizing filenames in production builds.

[![Latest Version](https://img.shields.io/github/release/Levdbas/BasePlate.svg?style=flat)](https://github.com/Levdbas/BasePlate/releases)

## Features

-   Scss for stylesheets
-   Modular JavaScript via import
-   WebPack4 for compiling assets, moving & optimizing images, transpiling & minifying JS/CSS and cache busting.
-   Ready for lazyloading WordPress attachment images, theme images, theme background images & iframes
-   Currently in the process of getting ready for Gutenberg!
-   [Browsersync](http://www.browsersync.io/) for synchronized browser testing
-   [Bootstrap 4](http://getbootstrap.com/)
-   [Font Awesome](http://fontawesome.io/)

## Installation

To use BasePlate, you need to have PHP 7.0+ installed on your machine. You'll also need a recent version of [Node.js](https://nodejs.org/en) installed.

Install WordPress locally on your AMP stack with a virtual hostname, create a new folder in `wp-content/themes` with the desired name of your template. Clone the latest version of BasePlate inside your new folder.

Next step is to set the proxy adress for BrowserSync in the `assets/config.json` file.

To install required node modules:

```bash
yarn install
```

set correct proxy url in `assets/config.json`

#### How do I use webpack?

Run BrowserSync and check for changes and auto-compile on the go:

```bash
yarn run watch
```

During development:

```bash
yarn run development
```

Enable cache busting, optimizing images & minifying for production use:

```bash
yarn run production
```

## Plugins

Manage

[WordPress Packagist](https://wpackagist.org) comes straight out of the box with BasePlate. It mirrors the WordPress [plugin](https://plugins.svn.wordpress.org) and [theme](https://themes.svn.wordpress.org) directories as a Composer repository.

#### How do I use it?

Require the desired plugin or theme using `wpackagist-plugin` or `wpackagist-theme` as the vendor name or add your plugins by adding them to composer.json.

```bash
composer require wpackagist-plugin/polylang
```

run

```bash
composer install
```

to load desired plugins.

#### Example

This is an example of how your `composer.json` file might look like.

```json
"require": {
    "wpackagist-plugin/polylang": "^2.1",

},
```

Please visit [WordPress Packagist](https://wpackagist.org) website for more information and examples.

## Helpers

You can import JS files into the app.js to have a more modular approach to your javascript.

```js
//app.js
import exampleImport from './exampleImport';
...
exampleImport();
//exampleImport.js

function exampleImport(  ) {
  ...
}
export default exampleImport;
```

Asset helper:

```php
get_asset('folder/file.ext'); // returns URL to asset
the_asset('folder/file.ext'); // echoes url to asset
bp_lazyload_img($img_id, $size); // returns lazyloaded WordPress attachment
bp_lazyload_bg_img($img_id, $size); // returns HTML to be injected into an HTML element to lazyload a background image.
```

## Post Types

For [custom post types](https://codex.wordpress.org/Post_Types#Custom_Post_Types) we recommend looking at [Extended CPTs](https://github.com/johnbillion/extended-cpts) by [John Blackbourn](https://github.com/johnbillion). The package provides extended functionality to WordPress custom post types, allowing developers to quickly build post types without having to write the same code again and again.

```php
register_extended_post_type('event');
```

## Custom Fields

For [custom fields](https://codex.wordpress.org/Custom_Fields) we recommend looking at the following plugins:

-   [Advanced Custom Fields](http://www.advancedcustomfields.com) - Powerful fields for WordPress developers.

## License

[MIT](LICENSE) © [Erik van der Bas](https://basedonline.nl)
