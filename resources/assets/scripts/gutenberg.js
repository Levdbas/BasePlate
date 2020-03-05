import lazyLoad from './components/lazyLoad';

var ll = lazyLoad();

acf.addAction('render_block_preview', function($el, attributes) {
    ll.update();
});

$('body').on('click', '.acf-block-preview a:not( [href^="#"] )', function(e) {
    e.preventDefault();
});
