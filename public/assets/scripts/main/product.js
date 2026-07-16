document.addEventListener('DOMContentLoaded', function () {
    // Image gallery: click thumbnails to switch main image
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    thumbnails.forEach(function (btn) {
        btn.addEventListener('click', function () {
            thumbnails.forEach(function (t) { t.classList.remove('active', 'border-red-500'); t.classList.add('border-gray-200'); });
            this.classList.add('active', 'border-red-500');
            this.classList.remove('border-gray-200');
            mainImage.src = this.dataset.src;
            mainImage.alt = this.dataset.alt;
            mainImage.title = this.dataset.alt;
        });
    });

    // Star rating interaction
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach(function (input, index) {
        input.addEventListener('change', function () {
            document.querySelectorAll('input[name="rating"]').forEach(function (radioInput, radioIndex) {
                const icon = radioInput.nextElementSibling;
                if (radioIndex < index + 1) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-yellow-400');
                } else {
                    icon.classList.remove('fas', 'text-yellow-400');
                    icon.classList.add('far');
                }
            });
        });
    });

    // Initialize reviews Swiper
    if (document.querySelector('.reviews-slider')) {
        new Swiper('.reviews-slider', {
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: '.reviews-button-next',
                prevEl: '.reviews-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            }
        });
    }

    // Similar products Swiper
    if (document.querySelector('.similar-slider')) {
        new Swiper('.similar-slider', {
            slidesPerView: 2,
            spaceBetween: 12,
            pagination: { el: '.similar-pagination', clickable: true },
            navigation: { nextEl: '.similar-next', prevEl: '.similar-prev' },
            breakpoints: {
                480: { slidesPerView: 3 },
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 5 },
            }
        });
    }

    // Unit price switching
    const unitSelect = document.getElementById('unit-select');
    const currentPrice = document.getElementById('current-price');
    const currentUnit = document.getElementById('current-unit');
    const alternativePrices = document.getElementById('alternative-prices');
    const prices = window.__productPrices || {};

    if (unitSelect && currentPrice && currentUnit && alternativePrices) {
        unitSelect.addEventListener('change', function () {
            const selectedUnit = this.value;
            const selectedPrice = prices[selectedUnit];
            currentPrice.textContent = Number(selectedPrice).toLocaleString('ru-RU');
            currentUnit.textContent = '₽ / ' + selectedUnit;

            let altHtml = '';
            for (const [unit, price] of Object.entries(prices)) {
                if (unit !== selectedUnit) {
                    altHtml += '<span class="bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100"><strong class="text-red-600">' + Number(price).toLocaleString('ru-RU') + ' ₽</strong> / ' + unit + '</span>';
                }
            }
            alternativePrices.innerHTML = altHtml;
        });
    }

    // Honeypot validation for review form
    const reviewForm = document.querySelector('form[action="/api/reviews"]');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function (e) {
            const website = this.querySelector('input[name="website"]').value;
            if (website) {
                e.preventDefault();
                return false;
            }
        });
    }
});

/* ===== QUANTITY PRESETS ===== */
document.querySelectorAll('.qty-preset').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var inp = document.getElementById('cart-qty-input');
        if (inp) inp.value = this.getAttribute('data-qty');
    });
});

/* ===== FAVORITES ===== */
(function() {
    var STORAGE_KEY = 'kavstal_favorites';
    function getFavs() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch(e) { return []; } }
    function saveFavs(arr) { localStorage.setItem(STORAGE_KEY, JSON.stringify(arr)); }
    var favBtn = document.getElementById('product-fav-btn');
    if (!favBtn) return;
    var pid = favBtn.getAttribute('data-pid');
    function updateFavBtn() {
        var favs = getFavs();
        var isFav = favs.indexOf(pid) !== -1;
        var svgEmpty = '<svg width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
        var svgFilled = '<svg width="16" height="14" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
        favBtn.innerHTML = isFav ? svgFilled : svgEmpty;
        if (isFav) { favBtn.classList.add('border-red-300', 'bg-red-50'); favBtn.classList.remove('border-zinc-200'); }
        else { favBtn.classList.remove('border-red-300', 'bg-red-50'); favBtn.classList.add('border-zinc-200'); }
        var badge = document.getElementById('favCountBadge');
        if (badge) { var c = getFavs().length; badge.textContent = c > 99 ? '99+' : c; badge.style.display = c > 0 ? 'flex' : 'none'; }
    }
    updateFavBtn();
    favBtn.addEventListener('click', function() {
        var favs = getFavs(), idx = favs.indexOf(pid);
        if (idx === -1) favs.push(pid); else favs.splice(idx, 1);
        saveFavs(favs);
        updateFavBtn();
    });
})();

/* ===== SHARE ===== */
document.getElementById('product-share-btn').addEventListener('click', function() {
    if (navigator.share) {
        navigator.share({ title: document.title, url: window.location.href });
    } else if (navigator.clipboard) {
        navigator.clipboard.writeText(window.location.href);
        var tip = document.createElement('span');
        tip.textContent = 'Ссылка скопирована';
        tip.className = 'fixed bottom-4 left-1/2 -translate-x-1/2 bg-zinc-800 text-white text-xs px-3 py-1.5 rounded-lg z-50';
        document.body.appendChild(tip);
        setTimeout(function() { tip.remove(); }, 2000);
    }
});

function updateCartCount() {
    fetch('/api/cart/count').then(r => r.json()).then(d => {
        document.querySelectorAll('.cart-count-badge').forEach(el => {
            el.textContent = d.count > 99 ? '99+' : d.count;
            el.style.display = d.count > 0 ? 'flex' : 'none';
        });
    });
}

function addToCart(productId, quantity, unit) {
    const fd = new URLSearchParams();
    fd.append('product_id', productId);
    fd.append('quantity', quantity);
    fd.append('unit', unit);
    return fetch('/api/cart/add', { method: 'POST', body: fd }).then(r => r.json());
}

updateCartCount();
(function() {
    var qtyInp = document.getElementById('cart-qty-input');
    var pid = qtyInp ? qtyInp.dataset.productId : '';
    if (!pid) return;
    fetch('/api/cart/products').then(r => r.json()).then(d => {
            if ((d.products || []).indexOf(pid) !== -1) {
            var btn = document.getElementById('add-to-cart-btn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-plus"></i> В корзине';
                btn.classList.add('bg-green-600', 'in-cart');
            }
        }
    });
})();

document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-to-cart-btn');
    if (!addBtn) return;

    const qtyInput = document.getElementById('cart-qty-input');
    const unitSelect = document.getElementById('cart-unit-select');
    const feedback = document.getElementById('cart-feedback');

    document.querySelectorAll('.cart-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let val = parseInt(qtyInput.value) || 1;
            if (this.classList.contains('cart-qty-plus')) val += 1;
            else if (val > 1) val -= 1;
            qtyInput.value = val;
        });
    });

    addBtn.addEventListener('click', function() {
        const pid = qtyInput.dataset.productId;
        const qty = parseFloat(qtyInput.value) || 1;
        const unit = unitSelect.value;

        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Добавление...';

        addToCart(pid, qty, unit).then(r => {
            if (r.success) {
                feedback.className = 'text-sm font-medium text-green-600';
                feedback.textContent = '✓ Товар добавлен в корзину!';
                this.classList.add('bg-green-600', 'in-cart');
                this.innerHTML = '<i class="fas fa-plus"></i> В корзине';
                updateCartCount();
            } else {
                feedback.className = 'text-sm font-medium text-red-600';
                feedback.textContent = 'Ошибка: ' + (r.error || 'повторите попытку');
                this.innerHTML = '<i class="fas fa-shopping-cart"></i> В корзину';
            }
            this.disabled = false;
            setTimeout(() => { feedback.className = 'hidden'; }, 3000);
        }).catch(() => {
            feedback.className = 'text-sm font-medium text-red-600';
            feedback.textContent = 'Ошибка сети';
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-shopping-cart"></i> В корзину';
        });
    });
});

/* ===== IMAGE LIGHTBOX ===== */
(function() {
    var lb = document.getElementById('imageLightbox');
    var lbImg = document.getElementById('lbImage');
    var lbCounter = document.getElementById('lbCounter');
    var lbPrev = document.getElementById('lbPrev');
    var lbNext = document.getElementById('lbNext');
    var closeBtn = document.getElementById('closeLightbox');
    var mainImg = document.getElementById('main-image');
    if (!lb) return;

    var images = window.__productImages || [];
    if (!images.length) return;
    var current = 0;

    function showLB(idx) {
        current = idx;
        lbImg.src = images[current];
        lbImg.alt = 'Фото ' + (current + 1) + ' из ' + images.length;
        lbCounter.textContent = (current + 1) + ' / ' + images.length;
        lb.classList.remove('hidden');
        lb.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function hideLB() {
        lb.classList.add('hidden');
        lb.classList.remove('flex');
        document.body.style.overflow = '';
    }

    if (mainImg) {
        mainImg.style.cursor = 'zoom-in';
        mainImg.addEventListener('click', function() {
            var idx = images.indexOf(this.src);
            showLB(idx !== -1 ? idx : 0);
        });
    }

    document.querySelectorAll('.thumbnail-btn').forEach(function(btn) {
        btn.addEventListener('dblclick', function() {
            var idx = images.indexOf(this.dataset.src);
            showLB(idx !== -1 ? idx : 0);
        });
    });

    document.querySelectorAll('.product-gallery-mobile .swiper-slide img').forEach(function(img) {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', function() {
            var idx = images.indexOf(this.src);
            showLB(idx !== -1 ? idx : 0);
        });
    });

    closeBtn.addEventListener('click', hideLB);
    lb.addEventListener('click', function(e) { if (e.target === lb) hideLB(); });
    document.addEventListener('keydown', function(e) {
        if (lb.classList.contains('hidden')) return;
        if (e.key === 'Escape') hideLB();
        if (e.key === 'ArrowLeft') showLB(current > 0 ? current - 1 : images.length - 1);
        if (e.key === 'ArrowRight') showLB(current < images.length - 1 ? current + 1 : 0);
    });
    lbPrev.addEventListener('click', function(e) { e.stopPropagation(); showLB(current > 0 ? current - 1 : images.length - 1); });
    lbNext.addEventListener('click', function(e) { e.stopPropagation(); showLB(current < images.length - 1 ? current + 1 : 0); });
})();

/* ===== MOBILE GALLERY SWIPER ===== */
(function() {
    var gallery = document.querySelector('.product-gallery-mobile');
    if (!gallery) return;
    new Swiper(gallery, {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: { el: '.product-gallery-pagination', clickable: true },
    });
})();

/* ===== TABS ===== */
document.querySelectorAll('.tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var tabId = this.getAttribute('data-tab');
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.classList.remove('text-red-600', 'border-red-600');
            b.classList.add('text-gray-500', 'border-transparent');
            b.setAttribute('aria-selected', 'false');
        });
        this.classList.remove('text-gray-500', 'border-transparent');
        this.classList.add('text-red-600', 'border-red-600');
        this.setAttribute('aria-selected', 'true');
        document.querySelectorAll('.tab-content').forEach(function(c) {
            c.classList.add('hidden');
        });
        document.getElementById(tabId).classList.remove('hidden');
    });
});

/* ===== ACCORDION ===== */
document.querySelectorAll('.accordion-header').forEach(function(header) {
    header.addEventListener('click', function() {
        var expanded = this.getAttribute('aria-expanded') === 'true';
        var body = this.nextElementSibling;
        this.setAttribute('aria-expanded', !expanded);
        if (expanded) {
            body.classList.remove('open');
            body.style.maxHeight = '0';
            body.style.paddingTop = '0';
            body.style.paddingBottom = '0';
        } else {
            body.classList.add('open');
            body.style.maxHeight = body.scrollHeight + 'px';
            body.style.paddingTop = '';
            body.style.paddingBottom = '';
            setTimeout(function() { body.style.maxHeight = 'none'; }, 300);
        }
    });
});

/* ===== BUY IN 1 CLICK MODAL ===== */
(function() {
    var btn = document.getElementById('buy-one-click-btn');
    var modal = document.getElementById('buyOneClickModal');
    var closeBtn = document.getElementById('closeBuyModal');
    var form = document.getElementById('buyOneClickForm');
    if (!btn || !modal) return;
    function openModal() { modal.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.remove('active'); document.body.style.overflow = ''; }
    btn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
    if (form) {
        form.addEventListener('submit', function(e) {
            if (this.querySelector('input[name="website"]').value) { e.preventDefault(); return; }
            var fd = new FormData(this);
            fetch('/api/orders/quick', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    if (d.success) {
                        form.innerHTML = '<div class="text-center py-8"><div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-lg font-medium text-gray-900">Заявка отправлена!</p><p class="text-sm text-gray-500 mt-1">Перезвоним в течение 15 минут</p></div>';
                    } else {
                        alert('Ошибка: ' + (d.error || 'повторите попытку'));
                    }
                })
                .catch(function() { alert('Ошибка сети'); });
            e.preventDefault();
        });
    }
})();

/* ===== MOBILE STICKY CART SYNC ===== */
(function() {
    var desktopBtn = document.getElementById('add-to-cart-btn');
    var mobileBtn = document.getElementById('mobile-add-to-cart-btn');
    var desktopQty = document.getElementById('cart-qty-input');
    var mobileQty = document.getElementById('mobile-qty-input');
    var unitSelect = document.getElementById('cart-unit-select');
    if (!desktopBtn || !mobileBtn) return;

    if (desktopQty && mobileQty) {
        mobileQty.addEventListener('input', function() { desktopQty.value = this.value; });
        desktopQty.addEventListener('input', function() { mobileQty.value = this.value; });
    }

    function syncMobileBtn() {
        if (desktopBtn.classList.contains('in-cart')) {
            mobileBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> В корзине';
            mobileBtn.classList.add('bg-green-600');
            mobileBtn.classList.remove('bg-red-600');
        } else {
            mobileBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> В корзину';
            mobileBtn.classList.remove('bg-green-600');
            mobileBtn.classList.add('bg-red-600');
        }
    }
    mobileBtn.addEventListener('click', function() {
        if (mobileQty && desktopQty) desktopQty.value = mobileQty.value;
        desktopBtn.click();
        syncMobileBtn();
    });
    var observer = new MutationObserver(syncMobileBtn);
    observer.observe(desktopBtn, { attributes: true, attributeFilter: ['class'] });
    syncMobileBtn();
})();

/* ===== PROGRESSIVE IMAGE LOADING ===== */
document.querySelectorAll('.product-gallery-img').forEach(function(img) {
    img.setAttribute('data-loaded', 'false');
    if (img.complete) { img.setAttribute('data-loaded', 'true'); return; }
    img.addEventListener('load', function() { this.setAttribute('data-loaded', 'true'); });
    img.addEventListener('error', function() { this.setAttribute('data-loaded', 'true'); });
});

/* ===== BREADCRUMBS: chevron separators ===== */
document.querySelectorAll('nav .mx-2').forEach(function(sep) {
    sep.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>';
    sep.className = 'mx-1 text-gray-300';
});
