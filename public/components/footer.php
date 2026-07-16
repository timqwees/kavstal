<?php
$siteInfo = $siteInfo ?? $site ?? [];
$phone_clean = $siteInfo['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $siteInfo['phone'] ?? '+74959892420');
$vk_url = $siteInfo['vk'] ? 'https://vk.com/' . $siteInfo['vk'] : '#';
$tg_url = $siteInfo['telegram'] ? 'https://t.me/' . $siteInfo['telegram'] : '#';
$wa_url = $siteInfo['whatsapp'] ? 'https://wa.me/' . $siteInfo['whatsapp'] : '#';
?>
<footer class="bg-white">
  <!-- PIK-style 4-column grid -->
  <div class="max-w-7xl mx-auto px-4 lg:px-8" style="display:grid; border-top:1px solid rgb(221,220,219); border-bottom:1px solid rgb(221,220,219); grid-template-columns:repeat(4,1fr);">
    <!-- Column 1: Catalog -->
    <div style="width:100%; display:flex; justify-content:center; align-items:center; flex-direction:column; padding:28px 16px;">
      <div style="color:rgb(19,19,19); font-size:14px; font-weight:500; margin-bottom:24px; text-align:center;">Новые поступления</div>
      <a href="/market" style="display:inline-flex; align-items:center; justify-content:center; height:56px; padding:0px 32px; border-radius:32px; background:rgb(252,76,2); color:white; font-size:16px; font-weight:600; letter-spacing:-0.32px; text-decoration:none; transition:background 0.2s;" onmouseover="this.style.background='rgb(220,60,0)'" onmouseout="this.style.background='rgb(252,76,2)'">Смотреть →</a>
    </div>

    <!-- Column 2: Phone -->
    <div style="width:100%; display:flex; justify-content:center; align-items:center; flex-direction:column; padding:28px 16px;">
      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" style="color:rgb(19,19,19); font-size:14px; font-weight:500; margin-bottom:24px; text-decoration:none; text-align:center;"><?= htmlspecialchars($siteInfo['phone'] ?? '+7 (495) 989-24-20') ?></a>
      <button type="button" onclick="document.getElementById('callbackModal').classList.remove('hidden')" style="display:inline-flex; align-items:center; justify-content:center; height:56px; padding:0px 32px; border-radius:32px; border:1px solid rgb(221,220,219); background:white; color:rgb(19,19,19); font-size:16px; font-weight:500; letter-spacing:-0.32px; cursor:pointer; transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgb(171,170,170)'" onmouseout="this.style.borderColor='rgb(221,220,219)'">Перезвоните мне</button>
    </div>

    <!-- Column 3: Contact form -->
    <div style="width:100%; display:flex; justify-content:center; align-items:center; flex-direction:column; padding:28px 16px;">
      <div style="color:rgb(19,19,19); font-size:14px; font-weight:500; margin-bottom:24px; text-align:center;">Есть вопросы или предложения?</div>
      <a href="/contacts" style="display:inline-flex; align-items:center; justify-content:center; height:56px; padding:0px 32px; border-radius:32px; border:1px solid rgb(221,220,219); background:white; color:rgb(19,19,19); font-size:16px; font-weight:500; letter-spacing:-0.32px; text-decoration:none; transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgb(171,170,170)'" onmouseout="this.style.borderColor='rgb(221,220,219)'">Написать</a>
    </div>

    <!-- Column 4: Quick quote -->
    <div style="width:100%; display:flex; justify-content:center; align-items:center; flex-direction:column; padding:28px 16px;">
      <div style="color:rgb(19,19,19); font-size:14px; font-weight:500; margin-bottom:24px; text-align:center;">Подбор металлопроката</div>
      <a href="/market" style="display:inline-flex; align-items:center; justify-content:center; height:56px; padding:0px 32px; border-radius:32px; background:rgb(252,76,2); color:white; font-size:16px; font-weight:600; letter-spacing:-0.32px; text-decoration:none; transition:background 0.2s;" onmouseover="this.style.background='rgb(220,60,0)'" onmouseout="this.style.background='rgb(252,76,2)'">Подобрать →</a>
    </div>
  </div>

  <!-- Bottom row -->
  <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 lg:py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
      <!-- Company -->
      <div class="col-span-2 md:col-span-1">
        <a href="/" class="inline-block mb-4">
          <img loading="lazy" class="h-8 block" src="<?= ($siteInfo['baseUrl'] ?? '') ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($siteInfo['company'] ?? 'КАВ СТАЛЬ') ?>">
        </a>
        <p class="text-sm text-gray-500 leading-relaxed mb-4 max-w-[260px]">
          Поставка металлопроката по Москве и МО. Собственный склад, сертификаты ГОСТ.
        </p>
        <div class="flex gap-2">
          <a href="<?= $vk_url ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="VK">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z"/><path d="M12.5 16.5h-1s-3.5 0-3.5-3.5c0-3.5 3.5-3.5 3.5-3.5h.5v2h-1s-1 0-1 1.5 1 1.5 1 1.5h1v-3h1.5l.5-1.5H13V7h2.5v2.5H17l-.5 1.5H15.5v1c0 .5.5 1.5 1.5 1.5h1v2h-2s-1 0-1.5-1c0 0-.5-1-.5-2v-.5"/></svg>
          </a>
          <a href="<?= $tg_url ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="Telegram">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z"/><path d="M6.5 12.5l3.5 1.5 1.5 4 5-8-10-3z"/></svg>
          </a>
          <a href="<?= $wa_url ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="WhatsApp">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z"/><path d="M16.5 14.5c-.2.6-.8 1-1.4 1.1-.6.1-1.2.1-1.8-.2-.6-.3-1.5-.9-2.5-1.9s-1.6-1.9-1.9-2.5c-.3-.6-.3-1.2-.2-1.8.1-.6.5-1.2 1.1-1.4.2-.1.4-.1.5 0 .1 0 .2.1.3.3l.6 1.2c.1.2.1.3 0 .5-.1.1-.1.2-.2.3l-.4.5c-.1.1-.1.2-.1.3 0 .1.1.3.2.4.4.7 1 1.3 1.7 1.7.1.1.3.2.4.2.1 0 .2 0 .3-.1l.5-.4c.2-.1.3-.2.5-.2.2 0 .3 0 .5.1l1.2.6c.2.1.3.2.3.3 0 .2 0 .4-.1.5z"/></svg>
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
            <a href="mailto:<?= htmlspecialchars($siteInfo['email'] ?? 'zakaz@kavstal.ru') ?>" class="text-sm text-gray-600 hover:text-red-600 transition-colors flex items-center gap-2">
              <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
              <?= htmlspecialchars($siteInfo['email'] ?? 'zakaz@kavstal.ru') ?>
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
              <?= htmlspecialchars($siteInfo['workingHours'] ?? 'Пн-Пт: 9:00-18:00, Сб: 9:00-15:00') ?>
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
        <a href="#" class="text-gray-400 hover:text-red-600 transition-colors">Политика конфиденциальности</a>
      </div>
    </div>
  </div>
</footer>
