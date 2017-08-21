# BasePlate

BasePlate is a bare theme for WordPress that includes an up-to-date assets manager via laravel-mix/WebPack. BasePlate lends a lot of code from Sage and WordPlate. By combining these two templates a lightweight (only two files, compressed ~ 330kb, featuring full bootstrap 4 css and js and [jQuery slim](https://stackoverflow.com/questions/35424053/what-are-the-differences-between-normal-and-slim-package-of-jquery)), easy to use template was created.
It ditches the full WP installation from WordPlate while maintaining the buildtools and uses core code from sage while ditching the blade template modules.

[![Latest Version](https://img.shields.io/github/release/Levdbas/BasePlate.svg?style=flat)](https://github.com/Levdbas/BasePlate/releases)

## Features

* Sass for stylesheets
* [Laravel Mix](https://laravel.com/docs/5.4/mix) for compiling assets, moving images, concatenating & minifying files and last but not least, cache busting.
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Bootstrap 4 beta](http://getbootstrap.com/)
* [Font Awesome](http://fontawesome.io/)

## Installation

To use BasePlate, you need to have PHP 7.0+ installed on your machine. You'll also need a recent version of [Node.js](https://nodejs.org/en) and [NPM](https://www.npmjs.com) installed if you want to use [Laravel Mix](https://laravel.com/docs/5.4/mix) to compile your CSS and Javascript and maintain your images.

Install WordPress locally on your AMP stack with a virtual hostname, create a new folder in ```wp-content/themes``` with the desired name of your template. Clone the latest version of BasePlate inside your new folder.

Next step is to set the proxy adress for BrowserSync in the webpack.mix.js file.

To install required node modules:

```bash
npm install
```
## Useage of Laravel-mix

BasePlate has integrated [Laravel Mix](https://laravel.com/docs/5.4/mix) out of the box. It provides a clean, fluent API for defining basic Webpack build steps for your BasePlate template.

#### How do I use it?

Run BrowserSync and check for changes and auto-compile on the go:
```bash
npm run watch
```
During development:
```bash
npm run development
```

Enable cache busting and minifying for production use:
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

Asset helper:
```php
echo assetBase('images') // for images folder
echo assetBase('styles') // for style folder
echo assetBase('scripts') // for scripts folder
echo assetBase('fonts') // for fonts folder
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
