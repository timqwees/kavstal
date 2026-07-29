document.addEventListener('submit', async function(e) {
    var form = e.target;
    if (form.tagName !== 'FORM' || form.method.toUpperCase() !== 'POST') return;
    if (form.dataset.ajax === 'false') return;

    e.preventDefault();

    var btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;

    try {
        var response = await fetch(form.action, { method: 'POST', body: new FormData(form) });
        if (!response.ok) throw new Error('HTTP ' + response.status);
        var data = await response.json();
        if (data.success) {
            form.innerHTML = '<div class="py-8 text-center"><div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-lg font-semibold">Спасибо!</p><p class="text-sm text-zinc-500 mt-1">Мы свяжемся с вами в ближайшее время.</p></div>';
        } else {
            alert(data.error || 'Ошибка при отправке');
            if (btn) btn.disabled = false;
        }
    } catch (error) {
        alert('Ошибка сети. Попробуйте ещё раз.');
        if (btn) btn.disabled = false;
    }
});
