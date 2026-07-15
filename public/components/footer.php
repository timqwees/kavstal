<?php
$siteInfo = $siteInfo ?? $site ?? [];
$phone_clean = $siteInfo['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $siteInfo['phone'] ?? '+74959892420');
$vk_url = $siteInfo['vk'] ? 'https://vk.com/' . $siteInfo['vk'] : '#';
$tg_url = $siteInfo['telegram'] ? 'https://t.me/' . $siteInfo['telegram'] : '#';
$wa_url = $siteInfo['whatsapp'] ? 'https://wa.me/' . $siteInfo['whatsapp'] : '#';
?>
<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <!-- Компания -->
            <div class="lg:col-span-1">
                <a href="/" class="inline-block mb-4">
                    <img loading="lazy" class="h-10" src="<?= $siteInfo['baseUrl'] ?? '' ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($siteInfo['company'] ?? 'КАВ СТАЛЬ') ?>">
                </a>
                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                    Поставка металлопроката по Москве и Московской области. Широкий ассортимент, сертифицированная продукция, собственный склад.
                </p>
                <div class="flex items-center gap-3">
                    <a href="<?= $vk_url ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-gray-100 hover:bg-red-50 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 transition" aria-label="VK">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M15.684 0H8.316C2.778 0 0 2.778 0 8.316v7.368C0 21.222 2.778 24 8.316 24h7.368C21.222 24 24 21.222 24 15.684V8.316C24 2.778 21.222 0 15.684 0zm3.6 11.262h-2.064c-.276 0-.42.18-.474.408-.384 1.338-1.458 2.562-2.562 2.562-.6 0-.792-.384-.792-.924v-2.634h-2.4v2.868c0 .786.264 1.338 1.212 1.338 1.416 0 2.478-1.788 2.97-3.018.072-.192.048-.306-.162-.306h-1.104c-.252 0-.36.138-.48.408-.306.852-1.17 2.124-1.596 1.614-.426-.51-.102-1.446-.102-1.446V9.738h1.404c.3 0 .396.21.396.534v1.032c.78-1.032 1.332-1.506 2.04-1.506.606 0 .756.48.756 1.086 0 .414-.144.81-.498 1.392-.186.306-.54.456-.798.456-.336 0-.57-.18-.456-.42.084-.246.27-.528.27-.858 0-.522-.282-.756-.672-.756-.558 0-1.218.936-1.218 1.728 0 .456.198.762.678.852.114.018.228.03.348.03 1.044 0 2.082-1.002 2.472-1.8.468-.96.588-2.004.588-2.118 0-.012.012-.03.024-.03h3.228v.03c0 .264-.06.528-.564.528z"/></svg>
                    </a>
                    <a href="<?= $tg_url ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-gray-100 hover:bg-red-50 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 transition" aria-label="Telegram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.162c-.18 1.896-.955 6.497-1.35 8.618-.166.9-.495 1.202-.81 1.23-.69.063-1.213-.456-1.88-.894-1.056-.695-1.653-1.128-2.678-1.807-1.185-.786-.417-1.217.258-1.922.177-.185 3.242-2.973 3.302-3.227.008-.032.015-.152-.058-.215-.072-.063-.18-.042-.258-.025-.11.024-1.863 1.184-5.258 3.475-.498.342-.95.508-1.354.5-.446-.01-1.302-.252-1.94-.46-.78-.254-1.4-.39-1.346-.823.028-.227.342-.46.94-.698 3.688-1.607 6.147-2.665 7.378-3.174 3.514-1.458 4.244-1.71 4.72-1.718.105-.003.338.024.49.146.127.102.162.24.18.337.015.097.034.318.02.49z"/></svg>
                    </a>
                    <a href="<?= $wa_url ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-gray-100 hover:bg-red-50 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 transition" aria-label="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Продукция -->
            <div>
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-4">Продукция</h3>
                <ul class="space-y-2.5">
                    <li><a href="/market/katalog/sortovoy-prokat" class="text-sm text-gray-500 hover:text-red-600 transition">Сортовой прокат</a></li>
                    <li><a href="/market/katalog/listovoy-prokat" class="text-sm text-gray-500 hover:text-red-600 transition">Листовой прокат</a></li>
                    <li><a href="/market/katalog/truby" class="text-sm text-gray-500 hover:text-red-600 transition">Трубы</a></li>
                    <li><a href="/market/katalog/nerzhaveyushchaya-stal" class="text-sm text-gray-500 hover:text-red-600 transition">Нержавеющая сталь</a></li>
                    <li><a href="/market/katalog/kachestvennye-stali" class="text-sm text-gray-500 hover:text-red-600 transition">Качественные стали</a></li>
                    <li><a href="/market/katalog/tsvetnye-metally" class="text-sm text-gray-500 hover:text-red-600 transition">Цветные металлы</a></li>
                    <li><a href="/market/katalog/metizy" class="text-sm text-gray-500 hover:text-red-600 transition">Метизы</a></li>
                </ul>
            </div>

            <!-- Услуги -->
            <div>
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-4">Услуги</h3>
                <ul class="space-y-2.5">
                    <li><a href="/delivery" class="text-sm text-gray-500 hover:text-red-600 transition">Доставка</a></li>
                    <li><a href="/services" class="text-sm text-gray-500 hover:text-red-600 transition">Резка металла</a></li>
                    <li><a href="/services" class="text-sm text-gray-500 hover:text-red-600 transition">Гибка</a></li>
                    <li><a href="/services" class="text-sm text-gray-500 hover:text-red-600 transition">Сварка</a></li>
                    <li><a href="/services" class="text-sm text-gray-500 hover:text-red-600 transition">Порошковая покраска</a></li>
                    <li><a href="/services" class="text-sm text-gray-500 hover:text-red-600 transition">Консультация</a></li>
                </ul>
            </div>

            <!-- Контакты -->
            <div>
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-4">Контакты</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="text-sm text-gray-500 hover:text-red-600 transition flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                            <?= htmlspecialchars($siteInfo['phone'] ?? '+7 (495) 989-24-20') ?>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:<?= htmlspecialchars($siteInfo['email'] ?? 'zakaz@kavstal.ru') ?>" class="text-sm text-gray-500 hover:text-red-600 transition flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <?= htmlspecialchars($siteInfo['email'] ?? 'zakaz@kavstal.ru') ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://yandex.ru/maps/?text=<?= urlencode($siteInfo['address'] ?? 'Москва, Семёновская площадь, 7') ?>" target="_blank" rel="noopener noreferrer" class="text-sm text-gray-500 hover:text-red-600 transition flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <?= htmlspecialchars($siteInfo['address'] ?? 'г. Москва, ул. Семёновская площадь, дом 7') ?>
                        </a>
                    </li>
                    <li>
                        <span class="text-sm text-gray-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <?= htmlspecialchars($siteInfo['workingHours'] ?? 'Пн-Пт: 9:00-18:00, Сб: 9:00-15:00') ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 mt-10 pt-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-400">© <?= date('Y') ?> <?= htmlspecialchars($siteInfo['company'] ?? 'КАВ СТАЛЬ') ?> | ИНН: 9719080724 | ОГРН: 1257700303838</p>
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    <a href="/about" class="text-gray-400 hover:text-red-600 transition">О компании</a>
                    <a href="/guarantees" class="text-gray-400 hover:text-red-600 transition">Гарантии</a>
                    <a href="/delivery" class="text-gray-400 hover:text-red-600 transition">Доставка и оплата</a>
                    <a href="/contacts" class="text-gray-400 hover:text-red-600 transition">Контакты</a>
                    <a href="#" class="text-gray-400 hover:text-red-600 transition">Политика конфиденциальности</a>
                </div>
            </div>
        </div>

        <!-- SEO / Перелинковка -->
        <div class="border-t border-gray-100 mt-4 pt-4">
            <p class="text-xs text-gray-300 text-center leading-relaxed">
                Металлобаза «КАВ СТАЛЬ» — поставки металлопроката в Москве и Московской области.
                <a href="/" class="text-gray-400 hover:text-red-600 transition">Металлопрокат</a> |
                <a href="/market/katalog/armatura" class="text-gray-400 hover:text-red-600 transition">Арматура</a> |
                <a href="/market/katalog/sortovoy-prokat" class="text-gray-400 hover:text-red-600 transition">Сортовой прокат</a> |
                <a href="/market/katalog/listovoy-prokat" class="text-gray-400 hover:text-red-600 transition">Листовой прокат</a> |
                <a href="/market/katalog/truby" class="text-gray-400 hover:text-red-600 transition">Трубы металлические</a> |
                <a href="https://yandex.ru/maps/?text=<?= urlencode($siteInfo['address'] ?? 'Москва, Семёновская площадь, 7') ?>" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-red-600 transition">г. Москва, ул. Семёновская площадь, дом 7</a>
            </p>
        </div>
    </div>
</footer>