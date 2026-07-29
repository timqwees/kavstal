document.querySelectorAll('form.ajax-form').forEach(form => {
  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    let result = this.querySelector('.form-result');

    if (!result) {
      result = document.createElement('div');
      result.className = 'form-result';
      this.appendChild(result);
    }

    try {
      const response = await fetch(this.action || '/submit.php', {
        method: this.method || 'POST',
        body: formData
      });

      if (!response.ok) throw new Error('Ошибка сервера: ' + response.status);

      const data = await response.json();

      result.innerHTML = `<p style="color:green">${data.message || 'Успешно отправлено!'}</p>`;
      this.reset();

    } catch (error) {
      result.innerHTML = `<p style="color:red">${error.message}</p>`;
    }
  });
});
