$(document).ready(() => {
  
  function lazyLoad($imgs) {
    const winHeight = $(window).height();

    $imgs.each((_, img) => {
      const rect = img.getBoundingClientRect();
      const $img = $(img);

      if (rect.top >= -200 && rect.top <= winHeight + 200) {
        if ($img.attr('data-src')) {
          $img.attr('src', $img.attr('data-src')).removeAttr('data-src');
          $img.on('load', () => $img.addClass('loaded'));
        }
      }
    });
  }

  lazyLoad($('.lazy'));

  const throttle = (func, delay) => {
    let timer;
    return () => {
      clearTimeout(timer);
      timer = setTimeout(() => func(), delay);
    };
  };

  const lazyLoadOnScroll = throttle(() => {
    lazyLoad($('.lazy:visible'));
  }, 100);

  $(window).on('scroll', lazyLoadOnScroll);
  $(window).on('resize', lazyLoadOnScroll);

});//end
