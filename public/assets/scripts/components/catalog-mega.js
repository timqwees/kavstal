(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var megaBtn = document.getElementById('catalogMegaBtn') || document.getElementById('ozonCatalogToggle');
    if (!megaBtn) return;

    var megaMenu = document.getElementById('catalogMega') || document.getElementById('ozonMegaMenu');
    var megaWrap = document.getElementById('catalogMegaWrap') || megaBtn.closest('.ozon-header') || megaBtn.parentElement;
    var sidebar = document.getElementById('catalogMegaSidebar') || document.getElementById('ozonMegaSidebar');
    var content = document.getElementById('catalogMegaContent') || (sidebar ? sidebar.nextElementSibling : null);
    var panels = content ? content.querySelectorAll('.ozon-mega-content-panel') : document.querySelectorAll('.ozon-mega-content-panel');
    var catItems = sidebar ? sidebar.querySelectorAll('.ozon-mega-item') : [];

    if (!megaMenu) return;

    function openMenu() {
      megaMenu.style.display = 'block';
      megaMenu.classList.remove('closing');
      void megaMenu.offsetHeight;
      megaMenu.classList.add('open');
      megaBtn.classList.add('active');
    }

    function closeMenu() {
      if (megaMenu.classList.contains('open')) {
        megaMenu.classList.remove('open');
        megaMenu.classList.add('closing');
        megaBtn.classList.remove('active');
        setTimeout(function() {
          megaMenu.style.display = 'none';
          megaMenu.classList.remove('closing');
        }, 200);
      } else {
        megaMenu.style.display = 'none';
        megaBtn.classList.remove('active');
      }
    }

    megaBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      if (megaMenu.style.display === 'none' || !megaMenu.classList.contains('open')) {
        openMenu();
      } else {
        closeMenu();
      }
    });

    document.addEventListener('click', function(e) {
      if (!megaWrap.contains(e.target)) {
        closeMenu();
      }
    });

    catItems.forEach(function(item) {
      item.addEventListener('mouseenter', function() {
        catItems.forEach(function(c) { c.classList.remove('active'); });
        item.classList.add('active');
        var catId = item.getAttribute('data-category-id');
        panels.forEach(function(p) {
          p.style.display = p.getAttribute('data-category-id') === catId ? 'block' : 'none';
        });
      });
    });
  });
})();
