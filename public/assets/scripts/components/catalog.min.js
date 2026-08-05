(function() {
  window.catalogAPI = {
    init: function() {
      const gridView = document.getElementById('grid-view');
      const listView = document.getElementById('list-view');
      const productsContainer = document.getElementById('products-container');

      if (gridView && listView && productsContainer) {
        gridView.addEventListener('click', function() {
          productsContainer.className = productsContainer.className
            .replace('flex flex-col gap-4', 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5');
          document.querySelectorAll('article').forEach(function(el) {
            el.className = el.className.replace('flex flex-row', 'flex flex-col');
          });
          this.classList.add('bg-white', 'rounded', 'shadow-sm');
          listView.classList.remove('bg-white', 'rounded', 'shadow-sm');
        });

        listView.addEventListener('click', function() {
          productsContainer.className = productsContainer.className
            .replace('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5', 'flex flex-col gap-4');
          document.querySelectorAll('article').forEach(function(el) {
            el.className = el.className.replace('flex flex-col', 'flex flex-row');
          });
          this.classList.add('bg-white', 'rounded', 'shadow-sm');
          gridView.classList.remove('bg-white', 'rounded', 'shadow-sm');
        });
      }

      document.querySelectorAll('.category-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
          e.preventDefault();
          const submenu = this.nextElementSibling;
          const chevron = this.querySelector('.category-chevron');

          document.querySelectorAll('.category-submenu').forEach(function(el) {
            if (el !== submenu) el.style.display = 'none';
          });
          document.querySelectorAll('.category-chevron').forEach(function(el) {
            if (el !== chevron) el.classList.remove('rotate-180');
          });

          if (submenu) {
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
          }
          if (chevron) {
            chevron.classList.toggle('rotate-180');
          }
        });
      });
    }
  };
})();
