/* Shared cart + favorites logic for kavstal.ru */
(function(){
    var FAV_KEY = 'kavstal_favorites';
    function getFavs(){ try { return JSON.parse(localStorage.getItem(FAV_KEY)) || []; } catch(e){ return []; } }
    function saveFavs(a){ localStorage.setItem(FAV_KEY, JSON.stringify(a)); }
    function isFav(pid){ return getFavs().indexOf(pid) !== -1; }

    window.updateCartCount = function(){
        fetch('/api/cart/count').then(function(r){ return r.json(); }).then(function(d){
            document.querySelectorAll('.cart-count-badge').forEach(function(el){
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    };

    window.addToCart = function(pid, qty, unit){
        var fd = new URLSearchParams();
        fd.append('product_id', pid);
        fd.append('quantity', qty);
        fd.append('unit', unit);
        return fetch('/api/cart/add', { method: 'POST', body: fd }).then(function(r){ return r.json(); });
    };

    var favSVG = '<svg width="13" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
    var favSVGFilled = '<svg width="13" height="11" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';

    function updateFavBtn(btn){
        var pid = btn.getAttribute('data-pid');
        if(!pid) return;
        btn.innerHTML = isFav(pid) ? favSVGFilled : favSVG;
        if(isFav(pid)){ btn.classList.add('border-red-300','bg-red-50'); btn.classList.remove('border-gray-200'); }
        else { btn.classList.remove('border-red-300','bg-red-50'); btn.classList.add('border-gray-200'); }
    }

    function updateHeaderFavCount(){
        var badge = document.getElementById('favCountBadge');
        if(!badge) return;
        var count = getFavs().length;
        badge.textContent = count > 99 ? '99+' : count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }

    function initFavBtns(){
        document.querySelectorAll('.add-to-fav-btn').forEach(function(btn){
            updateFavBtn(btn);
            btn.removeEventListener('click', favClickHandler);
            btn.addEventListener('click', favClickHandler);
        });
        updateHeaderFavCount();
    }

    function favClickHandler(){
        var pid = this.getAttribute('data-pid'); if(!pid) return;
        var favs = getFavs(), idx = favs.indexOf(pid);
        if(idx === -1) favs.push(pid); else favs.splice(idx, 1);
        saveFavs(favs);
        updateFavBtn(this);
        updateHeaderFavCount();
    }

    function initCartBtns(){
        var cartSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
        var checkSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
        var spinSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white animate-spin"><circle cx="12" cy="12" r="10" stroke-dasharray="31.4" stroke-dashoffset="10"/></svg>';

        document.querySelectorAll('.add-to-cart-btn').forEach(function(btn){
            btn.removeEventListener('click', cartClickHandler);
            btn.addEventListener('click', cartClickHandler);
        });
    }

    function cartClickHandler(){
        var card = this.closest('[itemscope]');
        var pid = this.getAttribute('data-pid');
        var unit = this.getAttribute('data-unit');
        var row = card ? card.querySelector('.hidden-cart-row') : null;
        var qtyInput = row ? row.querySelector('.cart-qty') : null;
        var qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
        var btn = this;
        var wasInCart = btn.classList.contains('in-cart');
        var cartSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
        var checkSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
        var spinSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white animate-spin"><circle cx="12" cy="12" r="10" stroke-dasharray="31.4" stroke-dashoffset="10"/></svg>';

        btn.disabled = true;
        btn.innerHTML = spinSvg;
        addToCart(pid, qty, unit).then(function(r){
            if(r.success){
                btn.innerHTML = checkSvg;
                btn.classList.add('bg-red-600','in-cart');
                setTimeout(function(){ btn.disabled = false; btn.innerHTML = checkSvg; }, 1500);
                updateCartCount();
            } else {
                btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-amber-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                setTimeout(function(){ btn.disabled = false; btn.innerHTML = wasInCart ? checkSvg : cartSvg; }, 1500);
            }
        }).catch(function(){
            btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-red-400"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
            setTimeout(function(){ btn.disabled = false; btn.innerHTML = wasInCart ? checkSvg : cartSvg; }, 1500);
        });
    }

    function restoreCartStates(){
        fetch('/api/cart/products').then(function(r){ return r.json(); }).then(function(d){
            var ids = d.products || [];
            if(!ids.length) return;
            var checkSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
            document.querySelectorAll('.add-to-cart-btn').forEach(function(btn){
                var pid = btn.getAttribute('data-pid');
                if(ids.indexOf(pid) !== -1){
                    btn.innerHTML = checkSvg;
                    btn.classList.add('bg-red-600','in-cart');
                }
            });
        });
    }

    function init(){
        updateCartCount();
        restoreCartStates();
        initFavBtns();
        initCartBtns();
    }

    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    window.kavstalCartFav = { init: init, initFavBtns: initFavBtns, initCartBtns: initCartBtns };
})();
