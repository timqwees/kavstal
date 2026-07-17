<!-- Header -->
<header class="bg-white border-b-[1px] border-[#bab9bb80] fixed w-full top-0 z-50">
    <nav class="mx-auto px-6 py-4 lg:py-0">
        <div class="flex justify-between items-center">
            <a href="/" class="relative flex items-center">
                <img loading="lazy" class="h-12 translate-y-1"
                    src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                    alt="<?= htmlspecialchars($site['company']) ?>">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/#catalog" class="py-6 text-gray-600 hover:text-red-500 transition">Каталог</a>
                <a href="/market" class="py-6 text-gray-600 hover:text-red-500 transition">Купить металл</a>
                <a href="/#calculator" class="py-6 text-gray-600 hover:text-red-500 transition">Калькулятор</a>
                <a href="/#prices" class="py-6 text-gray-600 hover:text-red-500 transition">Цены</a>
                <a href="/#about" class="py-6 text-gray-600 hover:text-red-500 transition">О компании</a>
                <a href="/#contacts" class="py-6 text-gray-600 hover:text-red-500 transition">Контакты</a>
            </div>

            <!-- Desktop Contact -->
            <div class="hidden lg:flex items-stretch items-end gap-6">
                <div class="flex flex-col justify-center items-center lg:hidden xl:flex">
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                        class="text-xl font-bold text-gray-800"><?= htmlspecialchars($site['phone']) ?></a>
                    <p class="text-sm text-gray-600">
                        <?= htmlspecialchars($site['workingHours']) ?>
                    </p>
                </div>
                <button class="bg-red-500 hidden md:block text-white px-6 rounded-lg hover:bg-red-500 transition py-2"
                    aria-label="Заказать обратный звонок">
                    Заказать звонок
                </button>
            </div>

            <div class="lg:hidden flex justify-between items-center gap-4">
                <button
                    class="hidden md:block lg:hidden text-sm bg-red-500 text-white p-2 rounded-lg hover:bg-red-500 transition"
                    aria-label="Заказать звонок">
                    Заказать звонок
                </button>
                <button class="lg:hidden mobile-menu-toggle p-2" aria-label="Открыть меню">
                    <div class="relative w-6 h-5">
                        <span class="absolute top-0 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                        <span class="absolute top-2 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                        <span class="absolute top-4 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                    </div>
                </button>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
<div class="mobile-menu fixed left-0 top-0 h-full w-80 bg-white shadow-xl z-50 lg:hidden overflow-y-auto scroll">
    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-2">
                <a href="/" class="relative flex items-center">
                    <img loading="lazy" class="h-12 translate-y-1"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
            </div>
            <button class="mobile-menu-close p-2" aria-label="Закрыть меню">
                <i class="fas fa-times text-2xl text-gray-800"></i>
            </button>
        </div>

        <nav class="space-y-4 mb-8">
            <a href="/#catalog"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">Каталог
                <i class="fa fa-arrow-right"></i>
            </a>
            <a href="/market"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">Купить
                металл
                <i class="fa fa-arrow-right"></i>
            </a>
            <a href="/#calculator"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">Калькулятор
                <i class="fa fa-arrow-right"></i>
            </a>
            <a href="/#prices"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">Цены
                <i class="fa fa-arrow-right"></i>
            </a>
            <a href="/#about"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">О
                компании
                <i class="fa fa-arrow-right"></i>
            </a>
            <a href="/#contacts"
                class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-500 rounded-lg transition">Контакты
                <i class="fa fa-arrow-right"></i>
            </a>
        </nav>

        <div class="border-t pt-6">
            <div class="text-center mb-6">
                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                    class="text-2xl font-bold text-gray-800 block mb-2">
                    <?= htmlspecialchars($site['phone']) ?>
                </a>
                <p class="text-sm text-gray-600">
                    <?= htmlspecialchars($site['workingHours']) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="/public/assets/scripts/main/header.min.js" defer></script>