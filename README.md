# BasePlate

BasePlate is a bare theme for WordPress that includes an up-to-date assets manager via WebPack. BasePlate lends some code from Sage. By combining these two templates a lightweight (only two files, compressed ~ 330kb, featuring full bootstrap 4 css and js and [jQuery slim](https://stackoverflow.com/questions/35424053/what-are-the-differences-between-normal-and-slim-package-of-jquery)), easy to use template was created.
It comes with a custom WebPack build for compiling css, js, importing jQuery, Bootstrap and manages assets such as fonts and images. Last but not least, it bust caches by randomizing filenames.

[![Latest Version](https://img.shields.io/github/release/Levdbas/BasePlate.svg?style=flat)](https://github.com/Levdbas/BasePlate/releases)

## Features

* Sass for stylesheets
* Stylesheet in footer, critical css from ```critical.scss``` gets loaded into the header.
* Modular JavaScript via import
* WebPack for compiling assets, moving & optimizing images, concatenating & minifying files and last but not least, cache busting.
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Bootstrap 4 beta](http://getbootstrap.com/)
* [Font Awesome](http://fontawesome.io/)

## Installation

To use BasePlate, you need to have PHP 7.0+ installed on your machine. You'll also need a recent version of [Node.js](https://nodejs.org/en) installed if you want to use webpack to compile your CSS and Javascript and maintain your images.

Install WordPress locally on your AMP stack with a virtual hostname, create a new folder in ```wp-content/themes``` with the desired name of your template. Clone the latest version of BasePlate inside your new folder.

Next step is to set the proxy adress for BrowserSync in the webpack.config.js file.

To install required node modules:

```bash
npm install
```
set correct proxy url in webpack.config.js on line 8

#### How do I use webpack?

Run BrowserSync and check for changes and auto-compile on the go:
```bash
npm run watch
```
During development:
```bash
npm run development
```

Enable cache busting, optimizing images & minifying for production use:
```bash
npm run production
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
You can import JS files into the app.js to modulize your code.
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
getAssetBase'folder','file.ext'); // returns URL to asset
assetBase'folder','file.ext'); // echoes url to asset
```


## Post Types

For [custom post types](https://codex.wordpress.org/Post_Types#Custom_Post_Types) we recommend looking at [Extended CPTs](https://github.com/johnbillion/extended-cpts) by [John Blackbourn](https://github.com/johnbillion). The package provides extended functionality to WordPress custom post types, allowing developers to quickly build post types without having to write the same code again and again.

```php
register_extended_post_type('event');
```

## Custom Fields

For [custom fields](https://codex.wordpress.org/Custom_Fields) we recommend looking at the following plugins:

- [Advanced Custom Fields](http://www.advancedcustomfields.com) - Powerful fields for WordPress developers.


## License

[MIT](LICENSE) © [Erik van der Bas](https://basedonline.nl)
