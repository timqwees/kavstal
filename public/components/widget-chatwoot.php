<?php
// Chatwoot widget — активируется только на мобильных устройствах
// на страницах без футера (все, кроме главной).
// На десктопе и на главной виджет подключается через footer.php.
?>
<style>
  @media (max-width: 1023px) {
    .woot-widget-bubble.woot-widget--expanded { bottom: 80px !important; }
    .woot--bubble-holder .woot-widget-bubble { bottom: 80px !important; }
    .woot-widget-bubble { width: 50px !important; height: 50px !important; }
    .woot-widget-bubble svg {
      all: revert;
      height: 20px !important;
      margin: 7px 0 0 0 !important;
      width: 20px !important;
    }
  }
</style>
<script defer>
  (function () {
    var p = location.pathname.replace(/\/+$/, '');
    var isHome = (p === '' || p === '/');
    var isMobile = window.matchMedia('(max-width: 767px)').matches;
    if (!(isMobile && !isHome)) return;
    window.chatwootSettings = { "position": "right", "type": "standard", "launcherTitle": "" };
    (function (d, t) {
      var BASE_URL = "https://app.chatwoot.com";
      var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
      g.src = BASE_URL + "/packs/js/sdk.js";
      g.async = true;
      var done = false;
      var timer = setTimeout(function () { if (!done) { done = true; if (g.parentNode) g.parentNode.removeChild(g); } }, 6000);
      g.onerror = function () { if (!done) { done = true; clearTimeout(timer); if (g.parentNode) g.parentNode.removeChild(g); } };
      s.parentNode.insertBefore(g, s);
      g.onload = function () {
        if (done) return;
        done = true; clearTimeout(timer);
        try { window.chatwootSDK.run({ websiteToken: 'Z16V1t3ANHodWwXFQanStee2', baseUrl: BASE_URL }); } catch (e) {}
      };
    })(document, "script");
  })();
</script>
