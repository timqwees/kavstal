document.head.insertAdjacentHTML('beforeend', '<style>@keyframes spin{to{transform:rotate(360deg)}}.ajax-spinner{display:inline-block;width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}</style>');

// === KAVSTAL: центральный триггер успешной отправки формы обратной связи ===
// Любая форма обратной связи при УСПЕХЕ диспатчит событие `kav:form:success` (и legacy `fetchit:success`).
// Обработчик в seo-head.php ловит это событие и вызывает `ym(..., 'reachGoal', 'KAVFROM')`.
// Поисковые формы (action="/market", input[name="search"]) намеренно исключены и событие не генерят.
(function() {
  var KAV_GOAL = 'KAVFROM';

  function isSearchForm(form) {
    if (!form || !form.matches) return false;
    // GET /market или наличие input[name="search"] без телефона — считаем поиском
    if (form.getAttribute('method') && form.getAttribute('method').toLowerCase() === 'get' && (form.action || '').indexOf('/market') !== -1) return true;
    if (form.querySelector('input[name="search"]') && !form.querySelector('input[name="phone"]')) return true;
    if (form.hasAttribute('data-search-form')) return true;
    return false;
  }

  function fireFeedbackSuccess(form, extraDetail) {
    var detail = Object.assign({
      goal: form.getAttribute('data-goal') || KAV_GOAL,
      formId: form.id || '',
      page: location.pathname,
      yclid: (window.getYclid && window.getYclid()) || ''
    }, extraDetail || {});
    // Триггер-событие — сама отправка формы вызывает событие, обработчик его ловит
    // Диспатчим только kav:form:success, fetchit:success для обратной совместимости — дедуп в обработчике отсеет дубль
    try { document.dispatchEvent(new CustomEvent('kav:form:success', {detail: detail, bubbles: true})); } catch(e) {}
    try { document.dispatchEvent(new CustomEvent('fetchit:success', {detail: detail, bubbles: true})); } catch(e) {}
  }

  // Экспортируем для ручных форм (modal, contacts, index) — можно вызвать window.__kavFireFeedbackSuccess(form, detail)
  window.__kavFireFeedbackSuccess = fireFeedbackSuccess;
  window.__kavIsSearchForm = isSearchForm;

  document.querySelectorAll('form.ajax-form').forEach(function(form) {
    if (isSearchForm(form)) return;
    form.addEventListener('submit', async function(e) {
      // Валидация как в примере заказчика: if (form.checkValidity()) { ym(...KAVFROM) }
      if (!this.checkValidity || !this.checkValidity()) return;
      e.preventDefault();

      var btn = this.querySelector('button[type="submit"]');
      var originalHtml = btn ? btn.innerHTML : null;
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="ajax-spinner"></span>';
      }

      var formData = new FormData(this);

      try {
        var response = await fetch(this.action || '/send/email', {
          method: this.method || 'POST',
          body: formData
        });

        if (!response.ok) throw new Error('Ошибка сервера: ' + response.status);

        var data = await response.json();
        if (data && data.success === false) throw new Error(data.error || 'Ошибка отправки');

        // === УСПЕХ — триггерим событие, обработчик в seo-head поймает и вызовет reachGoal KAVFROM ===
        fireFeedbackSuccess(this, {response: data, goal: this.getAttribute('data-goal') || KAV_GOAL});

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
})();
