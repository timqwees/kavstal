<?php
$siteInfo = $siteInfo ?? $site ?? [];
$phone_clean = $siteInfo['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $siteInfo['phone'] ?? '+74959892420');
?>
<style>
@media (max-width: 767px) {
    footer.bg-white { display: none; }
}
</style>
<footer class="bg-white">
  <!-- PIK-style 4-column grid -->
  <div class="max-w-7xl mx-auto px-4 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0" style="border-top:1px solid rgb(221,220,219); border-bottom:1px solid rgb(221,220,219);">
    <!-- Column 1 -->
    <div class="footer-grid-card flex flex-col items-center justify-center py-6 px-4">
      <div class="text-[rgb(19,19,19)] text-sm font-medium mb-5 text-center">Свяжитесь с нами</div>
      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" data-goal="click_phone" class="flex items-center justify-center w-full md:w-auto h-12 md:h-14 px-4 md:px-8 rounded-full bg-[#ef4444] text-white text-sm md:text-base font-semibold tracking-tight no-underline hover:bg-[#dc2626] transition">Позвонить в компанию</a>
    </div>

    <!-- Column 2 -->
    <div class="footer-grid-card flex flex-col items-center justify-center py-6 px-4">
      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="text-[rgb(19,19,19)] text-sm font-medium mb-1 no-underline text-center leading-tight"><?= htmlspecialchars($siteInfo['phone'] ?? '+7 (495) 989-24-20') ?></a>
      <div class="text-[rgb(100,100,100)] text-xs text-center mb-5 leading-tight">с 9 до 18</div>
      <button type="button" onclick="document.getElementById('callbackModal').classList.remove('hidden')" data-goal="open_callback" class="flex items-center justify-center w-full md:w-auto h-12 md:h-14 px-4 md:px-8 rounded-full border border-[rgb(221,220,219)] bg-white text-[rgb(19,19,19)] text-sm md:text-base font-medium tracking-tight cursor-pointer hover:border-[rgb(171,170,170)] transition">Перезвоните мне</button>
    </div>

    <!-- Column 3 -->
    <div class="footer-grid-card flex flex-col items-center justify-center py-6 px-4">
      <div class="text-[rgb(19,19,19)] text-sm font-medium mb-5 text-center">Есть вопросы или предложения?</div>
      <a href="https://t.me/kavstal_bot" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-full md:w-auto h-12 md:h-14 px-4 md:px-8 rounded-full border border-[rgb(221,220,219)] bg-white text-[rgb(19,19,19)] text-sm md:text-base font-medium tracking-tight no-underline hover:border-[rgb(171,170,170)] transition">Написать в Telegram</a>
    </div>

    <!-- Column 4 -->
    <div class="footer-grid-card flex flex-col items-center justify-center py-6 px-4">
      <div class="text-[rgb(19,19,19)] text-sm font-medium mb-5 text-center">Подбор металлопроката</div>
      <a href="/market" class="flex items-center justify-center w-full md:w-auto h-12 md:h-14 px-4 md:px-8 rounded-full bg-[#ef4444] text-white text-sm md:text-base font-semibold tracking-tight no-underline hover:bg-[#dc2626] transition">Подобрать →</a>
    </div>
  </div>

  <!-- Bottom row -->
  <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 lg:py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
      <!-- Company -->
      <div class="col-span-2 md:col-span-1 lg:col-span-1">
        <a href="/" class="inline-block mb-4">
          <img loading="lazy" class="h-8 block" src="<?= ($siteInfo['baseUrl'] ?? '') ?>/public/assets/images/icons/logo/logo.webp" alt="<?= htmlspecialchars($siteInfo['company'] ?? 'КАВ СТАЛЬ') ?>" width="160" height="36">
        </a>
        <p class="text-sm text-gray-500 leading-relaxed mb-4 max-w-[260px]">
          Поставка металлопроката по Москве и МО. Собственный склад, сертификаты ГОСТ.
        </p>
        <div class="flex gap-2">
          <a href="https://t.me/kavstal_bot" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="Telegram">
            <i class="fab fa-telegram text-xl"></i>
          </a>
          <a href="https://wa.me/74959892420" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="WhatsApp">
            <i class="fab fa-whatsapp text-xl"></i>
          </a>
        </div>
      </div>

      <!-- Products -->
      <div>
        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Продукция</h4>
        <ul class="space-y-2">
          <li><a href="/market/katalog/sortovoy-prokat" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Сортовой прокат</a></li>
          <li><a href="/market/katalog/listovoy-prokat" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Листовой прокат</a></li>
          <li><a href="/market/katalog/truby" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Трубы</a></li>
          <li><a href="/market/katalog/nerzhaveyushchaya-stal" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Нержавеющая сталь</a></li>
          <li><a href="/market/katalog/tsvetnye-metally" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Цветные металлы</a></li>
          <li><a href="/market/katalog/metizy" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Метизы</a></li>
        </ul>
      </div>

       <!-- Services -->
       <div>
         <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Контакты</h4>
         <ul class="space-y-2">
           <li><a href="/contacts" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Связаться с нами</a></li>
           <li><a href="/contacts" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Написать отзыв</a></li>
           <li><a href="/contacts" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Заказать звонок</a></li>
           <li><a href="/contacts" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Реквизиты</a></li>
         </ul>
       </div>

       <!-- Blog -->
       <div>
         <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Полезное</h4>
         <ul class="space-y-2">
           <li><a href="/blog" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Блог о металлопрокате</a></li>
           <li><a href="/blog/armatura-vidy-gost-kak-vybrat" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Виды арматуры</a></li>
           <li><a href="/blog/ves-metalloprokata-tablica" class="text-sm text-gray-600 hover:text-red-600 transition-colors">Вес металлопроката</a></li>
           <li><a href="/blog/gost-na-metalloprokat-spisok" class="text-sm text-gray-600 hover:text-red-600 transition-colors">ГОСТ на металл</a></li>
         </ul>
       </div>

      <!-- Contacts -->
      <div>
        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Контакты</h4>
        <ul class="space-y-3">
          <li>
            <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="text-sm text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <?= htmlspecialchars($siteInfo['phone'] ?? '+7 (495) 989-24-20') ?>
            </a>
          </li>
          <li>
            <a href="mailto:<?= htmlspecialchars($siteInfo['email'] ?? '') ?>" class="text-sm text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
              <?= htmlspecialchars($siteInfo['email'] ?? '') ?>
            </a>
          </li>
          <li>
            <span class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"/><path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
              <?= htmlspecialchars($siteInfo['address'] ?? 'г. Москва, Семёновская площадь, 7') ?>
            </span>
          </li>
          <li>
            <span class="text-sm text-gray-600 flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
09:00 - 18:00
            </span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Bottom -->
    <div class="border-t border-gray-200 mt-8 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-xs text-gray-400">© <?= date('Y') ?> <?= htmlspecialchars($siteInfo['company'] ?? 'КАВ СТАЛЬ') ?> | ИНН: 9719080724</p>
      <div class="flex flex-wrap gap-4 text-xs">
        <a href="/about" class="text-gray-400 hover:text-red-600 transition-colors">О компании</a>
        <a href="/guarantees" class="text-gray-400 hover:text-red-600 transition-colors">Гарантии</a>
        <a href="/delivery" class="text-gray-400 hover:text-red-600 transition-colors">Доставка</a>
        <a href="/contacts" class="text-gray-400 hover:text-red-600 transition-colors">Контакты</a>
        <a href="/blog" class="text-gray-400 hover:text-red-600 transition-colors">Блог</a>
      </div>
    </div>
  </div>
</footer>

<!-- Callback Modal -->
<div id="callbackModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/50 backdrop-blur-sm">
  <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 relative">
    <button type="button" onclick="document.getElementById('callbackModal').classList.add('hidden')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition">
      <i class="fas fa-times"></i>
    </button>
    <div class="text-center mb-6">
      <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-phone-alt text-red-600 text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-gray-900">Заказать звонок</h3>
      <p class="text-sm text-gray-500 mt-1">Оставьте номер — мы перезвоним в течение 15 минут</p>
    </div>
    <form id="callbackForm" class="space-y-4" data-goal="callback">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ваше имя</label>
        <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Иван Иванов">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Телефон *</label>
        <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="+7 (999) 123-45-67">
      </div>
      <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-3.5 rounded-xl font-bold hover:from-red-700 hover:to-red-800 transition shadow-lg shadow-red-200 flex items-center justify-center gap-2">
        <i class="fas fa-phone"></i> Перезвоните мне
      </button>
    </form>
    <p class="text-xs text-gray-400 text-center mt-4">Нажимая кнопку, вы соглашаетесь на обработку персональных данных</p>
  </div>
</div>

<script>
document.getElementById('callbackForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('button[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<svg class="animate-spin w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="31.4" stroke-dashoffset="10"/></svg> Отправляем...';
  fetch('/api/callback', { method: 'POST', body: new URLSearchParams(new FormData(this)) })
    .then(function(r) { return r.json(); })
    .then(function(d) {
      if (d.success) {
        document.getElementById('callbackModal').innerHTML = '<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center"><div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-check-circle text-green-600 text-2xl"></i></div><h3 class="text-xl font-bold text-gray-900 mb-2">Спасибо!</h3><p class="text-gray-500">Мы перезвоним вам в ближайшее время.</p><button type="button" onclick="document.getElementById(\'callbackModal\').classList.add(\'hidden\')" class="mt-6 px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">Закрыть</button></div>';
      } else {
        alert(d.error || 'Ошибка. Попробуйте ещё раз.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-phone"></i> Перезвоните мне';
      }
    })
    .catch(function() {
      alert('Ошибка отправки. Попробуйте ещё раз.');
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-phone"></i> Перезвоните мне';
    });
});
</script>

<style>
  @media only screen and (max-width: 767px) {
    .footer-grid-card { border-bottom: 1px solid rgb(221, 220, 219); }
    .footer-grid-card:last-child { border-bottom: none; }
  }
  @media only screen and (min-width: 768px) and (max-width: 1023px) {
    .footer-grid-card { border-bottom: 1px solid rgb(221, 220, 219); }
    .footer-grid-card:nth-child(3),
    .footer-grid-card:nth-child(4) { border-bottom: none; }
  }
</style>
<script>
  (function(){
    var p = location.pathname.replace(/\/+$/, '');
    if (window.matchMedia('(max-width: 767px)').matches && (p === '' || p === '/')) {
      document.querySelectorAll('footer.bg-white').forEach(function(f){ f.style.display = ''; });
    }
  })();
</script>
<?php include_once __DIR__ . '/widget-chatwoot.php'; ?>