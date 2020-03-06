# BasePlate

BasePlate is a starter theme for WordPress that includes an up-to-date asset manager via WebPack. It comes with a custom Webpack 4 build for compiling css, js, importing jQuery, Bootstrap and manages assets such as fonts and images. Last but not least, it utilizes cache busting by randomizing filenames in production builds.

[![Latest Version](https://img.shields.io/github/release/Levdbas/BasePlate.svg?style=flat)](https://github.com/Levdbas/BasePlate/releases)

## Features

-   Twig as a templating engine
-   Scss for stylesheets
-   Modular JavaScript via import
-   Webpack 4 for compiling assets, moving & optimizing images, transpiling & minifying JS/CSS and cache busting.

-   Ready for lazyloading WordPress attachment images, theme images, theme background images & iframes

-   Gutenberg ready.

-   [Browsersync](http://www.browsersync.io/) for synchronized browser testing

-   [Bootstrap 4](http://getbootstrap.com/), but import whatever you like.

## Installation

To use BasePlate, you need to have PHP 7.0+ installed on your machine. You'll also need a recent version of [Node.js](https://nodejs.org/en) installed.

Install WordPress locally on your AMP stack with a virtual hostname, create a new folder in `wp-content/themes` with the desired name of your template. Clone the latest version of BasePlate inside your new folder.

Next step is to set the proxy adress for BrowserSync with hot module reload in the `resources/assets/config.json` file.

**To install required node modules:**

```bash

yarn install

```

#### How do I use webpack?

Run BrowserSync and check for changes and auto-compile on the go:

```bash

yarn run watch

```

Run development build once. Useful for debugging build errors.

```bash

yarn run development

```

Run prodocution to enable cache busting, optimizing images & minifying for production use:

```bash

yarn run production

```

## Plugins

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

import  exampleImport  from  './exampleImport';

...

exampleImport();

//exampleImport.js



export default function  exampleImport( ) {

...

}


```

Asset helper:

```php
get_asset('folder/file.ext'); // returns URL to asset

the_asset('folder/file.ext'); // echoes url to asset

lazyload_img($img_id, $size); // returns lazyloaded WordPress attachment

lazyload_bg_img($img_id, $size); // returns HTML to be injected into an HTML element to lazyload a background image.
```

## Post Types

For [custom post types](https://codex.wordpress.org/Post_Types#Custom_Post_Types) we recommend generating them by using [Generate WP](https://generatewp.com/post-type/). One generated place the file in `lib/models/post-type-name.php`. This way, the post-types are within sourcecontrol as well.

## Custom Fields

For [custom fields](https://codex.wordpress.org/Custom_Fields) we use [Advanced Custom Fields](http://www.advancedcustomfields.com) - Powerful fields for WordPress developers. BasePlate comes out of the box with an `acf-json` folder to have field group definitions in source control as well.

## License

[MIT](LICENSE) © [Erik van der Bas](https://basedonline.nl)
