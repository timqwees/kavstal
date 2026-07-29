document.querySelectorAll('form.ajax-form').forEach(form => {
  form.addEventListener('submit', async function(e) {
    e.preventDefault();

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
      this.innerHTML = '<div class="py-8 text-center"><p class="text-red-500">' + error.message + '</p></div>';
    }
  });
});
