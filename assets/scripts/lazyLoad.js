import  lozad                  from 'lozad'
function lazyLoad(  ) {
  const observer = lozad('.lazyload', {
    rootMargin: '15px 0px', // syntax similar to that of CSS Margin
    threshold: 0.1,
    loaded: function(el) {
      // do something after the images are loaded
    }
  });
  observer.observe();

  // reserves space for the images that are going to be lazyloaded.
  $('img.lazyload').each(function() {
    var img = $(this);
    var width = img.attr('width');
    var height = img.attr('height');
    var height = img.width() / (width / height);
    $(this).css('min-height', height+'px');
  });

}

export default lazyLoad;
