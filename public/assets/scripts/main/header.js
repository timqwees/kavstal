$(document).ready(() => {
    // Mobile menu functionality
    const mobileMenuToggle = $('.mobile-menu-toggle');
    const mobileMenuClose = $('.mobile-menu-close');
    const mobileMenu = $('.mobile-menu');
    const mobileMenuOverlay = $('.mobile-menu-overlay');

    function openMobileMenu() {
        mobileMenu.addClass('active');
        mobileMenuOverlay.addClass('active');
        $('body').css('overflow', 'hidden');
    }

    function closeMobileMenu() {
        mobileMenu.removeClass('active');
        mobileMenuOverlay.removeClass('active');
        $('body').css('overflow', 'auto');
    }

    if (mobileMenuToggle.length) {
        mobileMenuToggle.on('click', () => {
            if (mobileMenu.hasClass('active')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    if (mobileMenuClose.length) {
        mobileMenuClose.on('click', closeMobileMenu);
    }

    if (mobileMenuOverlay.length) {
        mobileMenuOverlay.on('click', closeMobileMenu);
    }

    // Close menu when clicking on navigation links
    const mobileMenuLinks = mobileMenu.find('a[href^="#"]');
    mobileMenuLinks.each((index, link) => {
        $(link).on('click', closeMobileMenu);
    });

});//end