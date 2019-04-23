import LazyLoad from 'vanilla-lazyload/dist/lazyload.js';
import lazyLoad from './components/lazyLoad';

var ll = lazyLoad();

acf.addAction('render_block_preview', function($el, attributes) {
    ll.update();
});
