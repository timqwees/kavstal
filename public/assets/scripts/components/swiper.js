$(document).ready(() => {
    // Простая инициализация всех слайдеров
    if (typeof Swiper !== 'undefined') {
        console.log('Swiper загружен, инициализация слайдеров...');
        
         // Инициализация slider-type-4 (Projects)
        $('.slider-type-0').each(function() {
            new Swiper(this, {
                loop: true,
                speed: 1000,
                slidesPerView: 1,
                spaceBetween: 30,
                autoplay: { delay: 3000, disableOnInteraction: false },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            });
        });

        // Инициализация slider-type-1 (Portfolio)
        $('.slider-type-1').each(function() {
            new Swiper(this, {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 30,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        });
        
        // Инициализация slider-type-2 (Reviews)
        $('.slider-type-2').each(function() {
            new Swiper(this, {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 30,
                autoplay: { delay: 2000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { 
                    nextEl: '.reviews-button-next', 
                    prevEl: '.reviews-button-prev' 
                },
                breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        });
        
        // Инициализация slider-type-3 (Repair Types)
        $('.slider-type-3').each(function() {
            new Swiper(this, {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 30,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }
            });
        });
        
        // Инициализация slider-type-4 (Projects)
        $('.slider-type-4').each(function() {
            new Swiper(this, {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 30,
                autoplay: { delay: 4000, disableOnInteraction: false },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        });
        
        // News Swiper
        if (document.querySelector('.newsSwiper')) {
            new Swiper('.newsSwiper', {
                loop: false,
                slidesPerView: 'auto',
                spaceBetween: 14,
                freeMode: true,
                navigation: { nextEl: '#newsSwiperNext', prevEl: '#newsSwiperPrev' },
            });
        }

        console.log('Все слайдеры инициализированы!');
        
    } else {
        console.error('Swiper не загружен!');
        // Повторная попытка через 500мс
        setTimeout(() => $(document).ready(arguments.callee), 500);
    }
});//end