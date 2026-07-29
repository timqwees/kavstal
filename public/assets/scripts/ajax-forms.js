/**
 * Единый AJAX-обработчик для всех POST-форм на сайте.
 * Все формы с method="POST" автоматически отправляются через fetch.
 * Ответ — JSON { success: true/false, error?: string }.
 * При успехе — показывает success-элемент (data-success) или дефолтное сообщение.
 * При ошибке — alert с текстом ошибки.
 */
document.addEventListener('submit', function(e) {
    var form = e.target;
    if (form.tagName !== 'FORM' || form.method.toUpperCase() !== 'POST') return;
    if (form.dataset.ajax === 'false') return;

    e.preventDefault();

    var btn = form.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.dataset.originalHtml = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" fill="currentColor" class="opacity-75"/></svg>';
    }

    var action = form.action || '/send/email';
    var fd = new FormData(form);

    fetch(action, { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                var successEl = form.dataset.success;
                if (successEl) {
                    var target = document.getElementById(successEl);
                    if (target) {
                        form.style.display = 'none';
                        target.style.display = '';
                        return;
                    }
                }
                form.innerHTML = '<div class="py-8 text-center"><div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-lg font-semibold">Спасибо!</p><p class="text-sm text-zinc-500 mt-1">Мы свяжемся с вами в ближайшее время.</p></div>';
            } else {
                alert(d.error || 'Ошибка. Попробуйте ещё раз.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.dataset.originalHtml || 'Отправить';
                }
            }
        })
        .catch(function() {
            alert('Ошибка сети. Попробуйте ещё раз.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalHtml || 'Отправить';
            }
        });
});
