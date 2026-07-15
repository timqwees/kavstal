$(document).ready(function () {
    $('[data-toggle-section]').on('click', function () {
        var sectionId = $(this).attr('data-toggle-section');

        if ($('[data-toggle-section]').hasClass('bg_active')) {
            $('[data-toggle-section]').each(function () {
                $(this).removeClass('bg_active');
            });
            $(this).addClass('bg_active');
        }

        $('[data-section]').each(function () {
            $(this).css({
                'transition': 'opacity 0.3s',
                'opacity': 0
            });
            setTimeout(function () {
                $(this).addClass('hidden');
            }.bind(this), 300);
        });

        var targetSection = $('[data-section="' + sectionId + '"]');
        if (targetSection.length) {
            setTimeout(function () {
                targetSection.removeClass('hidden');
                targetSection.css({
                    'transition': 'opacity 0.3s',
                    'opacity': 0
                });
                setTimeout(function () {
                    targetSection.css('opacity', 1);
                }, 10);
            }, 300);
        }
    });
});