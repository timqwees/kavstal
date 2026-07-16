document.addEventListener('DOMContentLoaded', function(){
  var revealEls = document.querySelectorAll('.reveal');
  var revealObs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('reveal-visible'); revealObs.unobserve(e.target); } });
  },{threshold:0.1});
  revealEls.forEach(function(el){ revealObs.observe(el); });

  if(window.__products){
    (function(){
      var all = window.__products, grid = document.getElementById('catalog-grid'), btns = document.querySelectorAll('#catalog-filters [data-cat]'), active = '';

      function shuffle(a){ for(var i=a.length;i>1;i--){ var j=Math.floor(Math.random()*i); var t=a[i-1];a[i-1]=a[j];a[j]=t; } return a; }

      function render(cat){
        var filtered = cat ? all.filter(function(p){ return p.cat === cat; }) : all.slice();
        shuffle(filtered);
        var items = filtered.slice(0,8);
        if(!items.length){ grid.innerHTML='<div class="col-span-full text-center py-10 text-gray-400 text-sm">Товары не найдены</div>'; return; }
        var h = '';
        items.forEach(function(p){
          var u = Object.keys(p.units), fu = u[0], fp = p.units[fu].toLocaleString('ru-RU');
          h += '<div class="border border-gray-200 hover:border-gray-300 transition-all duration-200 rounded-xl p-3 flex flex-col bg-white" itemscope itemtype="https://schema.org/Product">' +
            '<meta itemprop="productID" content="' + p.id + '">' +
            '<div class="flex items-start justify-between gap-2 mb-2">' +
              '<span class="bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-md font-semibold flex-shrink-0 leading-relaxed">' + (p.badge||'Новинка') + '</span>' +
              '<button type="button" class="add-to-fav-btn w-7 h-7 rounded-md border border-gray-200 flex items-center justify-center shrink-0 hover:border-gray-400 hover:bg-gray-50 transition-colors" data-pid="' + p.id + '" title="В избранное">' +
                '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>' +
              '</button>' +
            '</div>' +
            '<a href="' + p.url + '" class="flex items-center justify-center h-[120px] mb-3 rounded-lg overflow-hidden bg-gray-50">' +
              (p.image ? '<img src="' + p.image + '" alt="" class="max-h-full max-w-full object-contain" loading="lazy">' : '<i class="fas fa-cube text-4xl text-gray-300"></i>') +
            '</a>' +
            '<div class="flex-1 flex flex-col min-w-0">' +
              '<a href="' + p.url + '" class="text-[13px] font-semibold text-gray-800 hover:text-red-600 transition-colors line-clamp-2 leading-snug mb-2 block min-h-[36px]">' + p.name + '</a>';
          if(p.specs && Object.keys(p.specs).length){
            var labels = ['Марка','Размер','ГОСТ','диаметр'];
            h += '<div class="flex flex-wrap gap-1 mb-2">';
            labels.forEach(function(l){
              var v = p.specs[l];
              if(v) h += '<span class="text-[10px] text-gray-500 bg-gray-50 border border-gray-100 px-1.5 py-0.5 rounded-md font-medium">' + l + ': <strong class="text-gray-700">' + v + '</strong></span>';
            });
            h += '</div>';
          }
          h += '<div class="mt-auto">' +
                '<div class="flex items-center gap-1.5 mb-2">' +
                  '<span class="inline-block w-1.5 h-1.5 rounded-full ' + (p.inStock ? 'bg-emerald-500' : 'bg-gray-300') + '"></span>' +
                  '<span class="text-[11px] font-medium ' + (p.inStock ? 'text-emerald-600' : 'text-gray-400') + '">' + (p.inStock ? 'В наличии' : 'Под заказ') + '</span>' +
                '</div>' +
                '<div class="flex items-end justify-between gap-2">' +
                  '<div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="min-w-0">' +
                    '<meta itemprop="priceCurrency" content="RUB">' +
                    '<div itemprop="price" content="' + fp + '" class="price-display text-[15px] font-bold text-gray-900 leading-tight">' + fp + ' ₽</div>' +
                    '<div class="flex gap-0.5 mt-1">' +
                      u.map(function(unit,k){
                        var pr = p.units[unit].toLocaleString('ru-RU');
                        return '<button type="button" class="text-[9px] px-1.5 py-0.5 rounded font-medium transition-all ' + (k===0?'bg-red-100 text-red-800':'bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-700') + '" data-unit="' + unit + '" data-price="' + pr + '" onclick="switchUnit(this)">' + unit + '</button>';
                      }).join('') +
                    '</div>' +
                  '</div>' +
                  '<button type="button" class="add-to-cart-btn w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shrink-0 transition-colors" data-pid="' + p.id + '" data-unit="' + fu + '" title="В корзину">' +
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>' +
                  '</button>' +
                '</div>' +
              '</div>' +
            '</div>' +
          '</div>';
        });
        grid.innerHTML = h;
        if(window.kavstalCartFav){ window.kavstalCartFav.initFavBtns(); window.kavstalCartFav.initCartBtns(); }
      }

      btns.forEach(function(btn){
        btn.addEventListener('click', function(){
          var cat = this.getAttribute('data-cat');
          active = cat;
          btns.forEach(function(b){
            b.className = 'inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium transition-colors ' + (b.getAttribute('data-cat') === active ? 'bg-red-500 text-white border border-red-500' : 'border border-gray-200 bg-white text-gray-600 hover:border-red-500 hover:text-red-500');
          });
          render(active);
        });
      });

      render('');
    })();
  }
});
