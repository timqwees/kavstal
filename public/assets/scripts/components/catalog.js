// Простые интерактивные элементы
(function() {
  window.catalogAPI = {
    init: function() {
      // Переключение вида
      $('#grid-view').click(function() {
        $('#products-container').removeClass('flex flex-col gap-4').addClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5');
        $('article').removeClass('flex flex-row').addClass('flex flex-col');
        $(this).addClass('bg-white rounded shadow-sm');
        $('#list-view').removeClass('bg-white rounded shadow-sm');
      });

      $('#list-view').click(function() {
        $('#products-container').removeClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5').addClass('flex flex-col gap-4');
        $('article').removeClass('flex flex-col').addClass('flex flex-row');
        $(this).addClass('bg-white rounded shadow-sm');
        $('#grid-view').removeClass('bg-white rounded shadow-sm');
      });

      // Выпадающие меню
      $('.category-toggle').click(function(e) {
        e.preventDefault();
        const submenu = $(this).next('.category-submenu');
        const chevron = $(this).find('.category-chevron');

        $('.category-submenu').not(submenu).slideUp();
        $('.category-chevron').not(chevron).removeClass('rotate-180');

        submenu.slideToggle();
        chevron.toggleClass('rotate-180');
      });
    }
  };
})();