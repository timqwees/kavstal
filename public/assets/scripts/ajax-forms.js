document.head.insertAdjacentHTML('beforeend', '<style>@keyframes spin{to{transform:rotate(360deg)}}.ajax-spinner{display:inline-block;width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}</style>');

document.querySelectorAll('form.ajax-form').forEach(form => {
  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const btn = this.querySelector('button[type="submit"]');
    const originalHtml = btn ? btn.innerHTML : null;
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<span class="ajax-spinner"></span>';
    }

    const formData = new FormData(this);

    try {
      const response = await fetch(this.action || '/submit.php', {
        method: this.method || 'POST',
        body: formData
      });

      if (!response.ok) throw new Error('Ошибка сервера: ' + response.status);

      const data = await response.json();

      this.innerHTML = '<div class="py-8 text-center"><div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-lg font-semibold">Спасибо!</p><p class="text-sm text-zinc-500 mt-1">Мы свяжемся с вами в ближайшее время.</p></div>';

    } catch (error) {
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
      }
      this.innerHTML = '<div class="py-8 text-center"><p class="text-red-500">' + error.message + '</p></div>';
    }
  });
});
