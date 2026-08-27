<?php
// Общий SEO-блок: гео-теги, верификация поисковиков, GTM, GA4, Яндекс.Метрика.
// Подключается в <head> каждой страницы сразу перед </head>.
$siteInfo = $siteInfo ?? $site ?? [];
$gscId  = $_ENV['GSC_ID']  ?? '';
$ga4Id  = $_ENV['GA4_ID']  ?? '';
$ymId   = $_ENV['YM_ID']   ?? '';
$ywebId = $_ENV['YWEB_ID'] ?? '';
$gadsId = $_ENV['GADS_ID'] ?? '';
?>
  <meta name="geo.region" content="RU-MOW">
  <meta name="geo.placename" content="Москва">
  <meta name="geo.position" content="55.765833;37.618889">
  <meta name="ICBM" content="55.765833, 37.618889">
  <meta name="theme-color" content="#dc2626">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-config" content="/browserconfig.xml">
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/images/icons/favicon/apple-touch-icon.png">

  <!-- SEO METRIKS -->
  <?php if ($gscId): ?><meta name="google-site-verification" content="<?= htmlspecialchars($gscId) ?>"><?php endif; ?>
  <?php if ($ywebId): ?><meta name="yandex-verification" content="<?= htmlspecialchars($ywebId) ?>" /><?php endif; ?>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KPHKLMXW');</script>
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPHKLMXW" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>

  <?php if ($ga4Id): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($ga4Id) ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= htmlspecialchars($ga4Id) ?>');
    <?php if ($gadsId): ?>gtag('config', '<?= htmlspecialchars($gadsId) ?>');<?php endif; ?>
  </script>
  <?php endif; ?>

  <?php if ($ymId): ?>
  <script>
    (function(m,e,t,r,i,k,a){
      m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
      m[i].l=1*new Date();
      for(var j=0;j<document.scripts.length;j++){if(document.scripts[j].src===r)return;}
      k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a);
    })(window,document,'script','https://mc.yandex.ru/metrika/tag.js','ym');
    ym(<?= htmlspecialchars($ymId) ?>,'init',{clickmap:true,trackLinks:true,accurateTrackBounce:true,webvisor:true,ecommerce:'dataLayer',forms:false});
    window.ymGoal = function(target, params){ try { ym(<?= htmlspecialchars($ymId) ?>,'reachGoal',target, params||{}); } catch(e){} };
    window.__ymId = "<?= htmlspecialchars($ymId) ?>";

    // === KAVSTAL: обработчик триггер-события успешной отправки формы обратной связи ===
    // Слушает событие `kav:form:success` (и legacy `fetchit:success`), которое диспатчит сама форма при успешном fetch.
    // Если событие появилось — вызывает ym reachGoal KAVFROM. Поисковые формы исключены.
    (function(){
      var KAV_GOAL = 'KAVFROM';
      var lastFire = 0, lastKey = '';
      function isSearchEvent(e){
        try {
          var d = (e && e.detail) || {};
          if (d.isSearch) return true;
          if (d.search || d.q) return true;
          if (d.form && d.form.matches) {
            if (d.form.matches('form[action*="/market"], form[role="search"]')) return true;
            if (d.form.querySelector('input[name="search"]') && !d.form.querySelector('input[name="phone"]')) return true;
          }
          if (d.action && String(d.action).indexOf('/market') !== -1 && String(d.method||'').toLowerCase()==='get') return true;
        } catch(ex){}
        return false;
      }
      function handleFeedbackSuccess(e){
        if (isSearchEvent(e)) return;
        var detail = (e && e.detail) || {};
        // защита от случайного срабатывания на поиске по query
        if (detail.search !== undefined || detail.q !== undefined) {
          if (!detail.phone && !detail.email && !detail.name) return;
        }
        // дедупликация: если тот же KAVFROM уже стрелял <1.2с назад (kav + fetchit диспатчат оба) — игнор
        var key = (detail.formId||'') + '|' + (detail.goal||KAV_GOAL);
        var now = Date.now();
        if (key === lastKey && (now - lastFire) < 1200) return;
        lastKey = key; lastFire = now;
        var params = {};
        try { params = Object.assign({page: location.pathname, yclid: window.getYclid ? window.getYclid() : ''}, detail); } catch(ex){ params = detail; }
        // Основная цель — KAVFROM (отправка всех форм обратной связи)
        try { ym(window.__ymId,'reachGoal',KAV_GOAL, params); } catch(ex){}
        // Дополнительно: если у формы был свой data-goal (callback, market_feedback и т.д.) — шлём и его
        var specificGoal = detail.goal && detail.goal !== KAV_GOAL ? detail.goal : null;
        if (specificGoal) { try { ym(window.__ymId,'reachGoal',specificGoal, params); } catch(ex){} }
        try { window.dataLayer = window.dataLayer || []; window.dataLayer.push({event:'kav_form_success', goal: KAV_GOAL, specificGoal: specificGoal, page: location.pathname}); } catch(ex){}
      }
      document.addEventListener('kav:form:success', handleFeedbackSuccess);
      document.addEventListener('fetchit:success', handleFeedbackSuccess);
      document.addEventListener('form:success', handleFeedbackSuccess);
    })();
  </script>
  <noscript><div><img src="https://mc.yandex.ru/watch/<?= htmlspecialchars($ymId) ?>" style="position:absolute;left:-9999px" alt=""></div></noscript>
  <?php endif; ?>

  <script>
    // === Yandex Direct: yclid capture ===
    // Сохраняем yclid из URL в localStorage на 30 дней
    (function(){
      var match = location.search.match(/[?&]yclid=([^&]+)/);
      if (match) {
        try { localStorage.setItem('yclid', match[1]); localStorage.setItem('yclid_ts', Date.now()); } catch(e){}
      }
      // Удаляем yclid старше 30 дней
      try {
        var ts = localStorage.getItem('yclid_ts');
        if (ts && Date.now() - parseInt(ts,10) > 30*24*60*60*1000) {
          localStorage.removeItem('yclid'); localStorage.removeItem('yclid_ts');
        }
      } catch(e){}
      window.getYclid = function(){ try { return localStorage.getItem('yclid') || ''; } catch(e){ return ''; } };
    })();

    // Универсальная отправка целей в Яндекс.Метрику и GA4
    window.trackGoal = function(target, params){
      params = params || {};
      params.yclid = window.getYclid();
      <?php if ($ymId): ?>try { ym(<?= htmlspecialchars($ymId) ?>,'reachGoal',target,params); } catch(e){}<?php endif; ?>
      <?php if ($ga4Id): ?>try { gtag('event', target, params); } catch(e){}<?php endif; ?>
    };

    // Fallback-обработчик для GA4/dataLayer когда Метрика не подключена (YM_ID пустой)
    // Если YM_ID есть — основной обработчик уже выше, здесь только GA4
    (function(){
      var KAV_GOAL = 'KAVFROM';
      var lastFire = 0, lastKey = '';
      function handleFallback(e){
        if (window.__ymId) return;
        var detail = (e && e.detail) || {};
        if (detail.search !== undefined || detail.q !== undefined) return;
        var key = (detail.formId||'') + '|' + (detail.goal||KAV_GOAL);
        var now = Date.now();
        if (key === lastKey && (now - lastFire) < 1200) return;
        lastKey = key; lastFire = now;
        var params = {};
        try { params = Object.assign({page: location.pathname, yclid: window.getYclid ? window.getYclid() : ''}, detail); } catch(ex){ params = detail; }
        <?php if ($ga4Id): ?>try { gtag('event', KAV_GOAL, params); } catch(ex){}<?php endif; ?>
        try { window.dataLayer = window.dataLayer || []; window.dataLayer.push({event:'kav_form_success', goal: KAV_GOAL, page: location.pathname}); } catch(ex){}
      }
      document.addEventListener('kav:form:success', handleFallback);
      document.addEventListener('fetchit:success', handleFallback);
    })();

    document.addEventListener('DOMContentLoaded', function(){
      var yclid = window.getYclid();

      // Внедряем yclid в каждую форму как скрытое поле (кроме поисковых — им yclid не нужен, но не мешает)
      if (yclid) {
        document.querySelectorAll('form').forEach(function(form){
          if (!form.querySelector('[name="yclid"]')) {
            // не добавляем в поисковую форму GET /market — у неё свой yclid через URL не нужен
            if (form.matches && form.matches('form[method="get"][action*="/market"]')) return;
            if (form.querySelector('input[name="search"]') && !form.querySelector('input[name="phone"]')) return;
            var inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'yclid'; inp.value = yclid;
            form.appendChild(inp);
          }
        });
      }

      // Формы обратной связи с data-goal: цель KAVFROM теперь срабатывает ТОЛЬКО через
      // центральный обработчик события `kav:form:success` (которое диспатчит сама форма при успешном fetch + checkValidity).
      // Прямой submit-трекинг отключён, чтобы поиск (GET /market?search=...) не попадал в цель "отправка всех форм".
      // Специфичные цели (callback, market_feedback и т.д.) также отправляются через тот же обработчик на событии успеха.

      // Кнопки с data-goal (не формы) — оставляем клик-трекинг
      document.querySelectorAll('[data-goal]').forEach(function(el){
        if (el.tagName === 'FORM') return;
        el.addEventListener('click', function(){
          window.trackGoal(el.getAttribute('data-goal'), {page: location.pathname});
        });
      });

      // Авто-трекинг кликов по телефону/email/мессенджерам
      document.querySelectorAll('a[href^="tel:"]').forEach(function(el){
        el.addEventListener('click', function(){
          window.trackGoal('click_phone', {page: location.pathname, phone: this.href});
        });
      });
      document.querySelectorAll('a[href^="mailto:"]').forEach(function(el){
        el.addEventListener('click', function(){
          window.trackGoal('click_email', {page: location.pathname, email: this.href});
        });
      });
      document.querySelectorAll('a[href*="t.me"], a[href*="tg://"], a[href*="telegram"]').forEach(function(el){
        el.addEventListener('click', function(){
          window.trackGoal('click_telegram', {page: location.pathname});
        });
      });
      document.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp"]').forEach(function(el){
        el.addEventListener('click', function(){
          window.trackGoal('click_whatsapp', {page: location.pathname});
        });
      });
    });
  </script>
