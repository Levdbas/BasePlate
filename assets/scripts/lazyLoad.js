import LazyLoad from 'vanilla-lazyload'
function lazyLoad() {
    var myLazyLoad = new LazyLoad({
        elements_selector: '.lazyload',
        callback_load: function(el) {
            $(el).css('min-height', 'auto')
        },
    })

    // reserves space for the images that are going to be lazyloaded.
    $('img.lazyload').each(function() {
        var img = $(this)
        var width = img.attr('width')
        var height = img.attr('height')
        var height = img.width() / (width / height)
        $(this).css('min-height', height + 'px')
    })
}

export default lazyLoad
