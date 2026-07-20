/* ===== LIVE SEARCH ===== */
(function() {
  var input = document.getElementById('searchInput'),
      dropdown = document.getElementById('searchDropdown'),
      wrap = document.getElementById('searchWrap'),
      timer = null,
      lastQuery = '',
      abortCtrl = null;
  if (!input || !dropdown) return;

  function highlight(text, q) {
    if (!q) return text;
    var esc = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    return text.replace(new RegExp('(' + esc + ')', 'gi'), '<mark class="bg-yellow-100 text-yellow-800 rounded px-0.5">$1</mark>');
  }

  function updateContent(html) {
    dropdown.innerHTML = html;
    if (dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      dropdown.style.maxHeight = '0';
      dropdown.style.opacity = '0';
      requestAnimationFrame(function() {
        dropdown.style.transition = 'max-height 0.25s ease, opacity 0.2s ease';
        dropdown.style.maxHeight = '420px';
        dropdown.style.opacity = '1';
      });
    } else {
      dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
    }

  }

  function showLoading(q) {
    updateContent(
      '<div class="flex items-center gap-3 px-4 py-3">' +
        '<i class="fas fa-spinner fa-spin text-red-600 text-lg"></i>' +
        '<span class="text-sm text-zinc-400">Поиск «' + q.replace(/</g,'&lt;') + '»…</span>' +
      '</div>'
    );
  }

  function renderResults(items, q) {
    if (!items.length) {
      updateContent(
        '<div class="px-4 py-6 text-center">' +
          '<svg class="w-8 h-8 mx-auto text-zinc-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>' +
          '<div class="text-sm text-zinc-400">Ничего не найдено</div>' +
          '<div class="text-xs text-zinc-300 mt-1">Попробуйте другой запрос</div>' +
        '</div>'
      );
      return;
    }
    var html = '<div class="max-h-[360px] overflow-y-auto">';
    items.forEach(function(p, i) {
      var img = p.image
        ? '<img src="' + p.image.replace(/"/g,'&quot;') + '" class="w-11 h-11 object-contain rounded-lg bg-zinc-50 border border-zinc-100 flex-shrink-0" loading="lazy">'
        : '<div class="w-11 h-11 rounded-lg bg-zinc-100 flex-shrink-0 flex items-center justify-center"><svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/></svg></div>';
      var stock = p.in_stock
        ? '<span class="inline-flex items-center gap-0.5 text-[10px] text-emerald-600 font-medium"><span class="w-1 h-1 rounded-full bg-emerald-500"></span>В наличии</span>'
        : '<span class="inline-flex items-center gap-0.5 text-[10px] text-zinc-400"><span class="w-1 h-1 rounded-full bg-zinc-300"></span>Под заказ</span>';
      var cat = p.cat ? '<span class="text-[10px] text-zinc-400">' + p.cat.replace(/</g,'&lt;') + '</span>' : '';
      html +=
        '<a href="' + p.url + '" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50/60 transition-all duration-150 group border-b border-zinc-50 last:border-0 search-item" style="animation: searchFadeIn ' + (0.03 * (i + 1)) + 's ease both">' +
          img +
          '<div class="flex-1 min-w-0">' +
            '<div class="text-[13px] text-zinc-800 truncate group-hover:text-red-700 transition-colors leading-snug">' + highlight(p.nameOrig.replace(/</g,'&lt;'), q) + '</div>' +
            '<div class="flex items-center gap-2 mt-0.5">' +
              '<span class="text-sm font-bold text-zinc-900">' + p.price + ' ₽</span>' +
              '<span class="text-[10px] text-zinc-400">/ ' + p.unit + '</span>' +
              stock +
            '</div>' +
            cat +
          '</div>' +
          '<svg class="w-4 h-4 text-zinc-300 group-hover:text-red-400 transition-colors flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>' +
        '</a>';
    });
    html += '</div>';
    html += '<a href="/market?search=' + encodeURIComponent(q) + '" class="flex items-center justify-center gap-2 text-xs text-red-600 hover:text-red-700 font-medium py-2.5 border-t border-zinc-100 hover:bg-red-50/50 transition-colors">' +
      '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6V5.25A2.25 2.25 0 0011.25 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 005.25 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>' +
      'Показать все результаты' +
    '</a>';
    updateContent(html);
  }

  function hideDD() {
    dropdown.style.transition = 'max-height 0.15s ease, opacity 0.1s ease';
    dropdown.style.maxHeight = '0';
    dropdown.style.opacity = '0';
    setTimeout(function() { dropdown.classList.add('hidden'); }, 160);
  }

  input.addEventListener('input', function() {
    var q = this.value.trim();
    clearTimeout(timer);
    if (q.length < 2) { hideDD(); lastQuery = ''; return; }
    if (q === lastQuery) return;
    lastQuery = q;
    if (abortCtrl) abortCtrl.abort();
    abortCtrl = new AbortController();
    showLoading(q);
    timer = setTimeout(function() {
      fetch('/api/search?q=' + encodeURIComponent(q) + '&limit=8', { signal: abortCtrl.signal })
        .then(function(r) { return r.json(); })
        .then(function(items) { renderResults(items, q); })
        .catch(function(e) { if (e.name !== 'AbortError') hideDD(); });
    }, 180);
  });

  input.addEventListener('focus', function() {
    if (dropdown.innerHTML && dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      requestAnimationFrame(function() {
        dropdown.style.transition = 'max-height 0.25s ease, opacity 0.2s ease';
        dropdown.style.maxHeight = '420px';
        dropdown.style.opacity = '1';
      });
    }
  });
  document.addEventListener('click', function(e) { if (!wrap.contains(e.target)) hideDD(); });
  input.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { hideDD(); input.blur(); }
    if (e.key === 'ArrowDown') { var first = dropdown.querySelector('a[href]'); if (first) { e.preventDefault(); first.focus(); } }
  });
})();
