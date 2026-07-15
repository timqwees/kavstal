$(document).ready(() => {
    window.sharePage = function () {
        const url = window.location.href;
        const description = $('meta[property="og:description"]').attr('content');

        navigator.share({
            text: description + ' ' + url,
            url: url
        });
    };
});